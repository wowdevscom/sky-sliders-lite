import React, { useState, useEffect, useContext, useRef } from 'react';
import { __ } from "@wordpress/i18n";
import axios from 'axios';
import Swal from 'sweetalert2';
import Switch from "react-switch";
import { AppContext } from "./AppContext";

import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {
  faCopy,
  faCheck,
  faClock,
  faTrash,
  faCheckDouble,
} from "@fortawesome/free-solid-svg-icons";


const RenderFeatures = ({ featuresType }) => {
  const { triggerRefresh } = useContext(AppContext);

  const [countUsed, setCountUsed] = useState(0);
  const [countUnused, setCountUnused] = useState(0);

  const [loading, setLoading] = useState(true);
  const [features, setFeatures] = useState([]);
  const [searchValue, setSearchValue] = useState(""); // State for search
  const [isSearchEmpty, setIsSearchEmpty] = useState(false); // State to track if search results are empty
  const [visibleFilter, setVisibleFilter] = useState("all"); // Track which filter is active
  const formRef = useRef(featuresType);

  useEffect(() => {
    const fetchFeatures = async () => {
      try {
        setLoading(true); // Ensure loading state starts before fetch

        const response = await axios.post(ajaxurl, new URLSearchParams({
          action: 'sky_sliders_get_settings',
          action_type: featuresType,
          _wpnonce: SkySlidersConfig.nonce
        }));
        if (response?.data?.success) {
          const features = Array.isArray(response?.data?.data) ? response.data.data : [];
          setFeatures(features);

          // Count used & unused widgets using reduce()
          const { used, unused } = features.reduce(
            (acc, feature) => {
              if (feature.total_used > 0) {
                acc.used += 1;
              } else {
                acc.unused += 1;
              }
              return acc;
            },
            { used: 0, unused: 0 } // Initial count values
          );

          setCountUsed(used);
          setCountUnused(unused);

        } else {
          Swal.fire({
            icon: 'error',
            title: __('Error', 'sky-sliders'),
            text: response?.data?.data?.message || __('Unknown error', 'sky-sliders')
          });
        }
      } catch (error) {
        Swal.fire({
          icon: 'error',
          title: __('Error', 'sky-sliders'),
          text: error.message
        });
      } finally {
        setLoading(false);
      }
    };

    fetchFeatures();
  }, [featuresType]); // Add featuresType to dependency array

  const handleSearch = (event) => {
    const searchValue = event.target.value.toLowerCase();
    setSearchValue(searchValue);

    const hasResults = features.some((feature) =>
      feature.label.toLowerCase().includes(searchValue)
    );
    setIsSearchEmpty(!hasResults);
  };

  const toggleAllFeatures = (value) => {
    setFeatures((prevFeatures) =>
      prevFeatures.map((feature) => {
        const matchesSearch = feature.label.toLowerCase().includes(searchValue);
        const matchesFilter =
          visibleFilter === "all" ||
          (visibleFilter === "used" && feature.total_used > 0) ||
          (visibleFilter === "unused" && feature.total_used === 0);
        if (matchesSearch && matchesFilter) {
          return { ...feature, value: value ? "on" : "off" };
        }
        return feature;
      })
    );
    formRef.current.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
  };

  if (loading) {
    return (
      <>
        <div className="text-center">{__('Loading', 'sky-sliders')}...</div>
        <div className="flex justify-center items-center h-40 mt-12"><div className="animate-spin rounded-full h-10 w-10 border-t-2 border-b-2 border-blue-500"></div></div>
      </>
    )
  }

  const submitForm = (event) => {
    event.preventDefault();

    const updatedFeatures = {};
    const formData = new FormData(event.target);
    for (const [key, value] of formData.entries()) {
      updatedFeatures[key] = value;
    }

    Swal.fire({
      title: 'Loading...',
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      }
    });

    const params = new URLSearchParams();
    Object.entries(updatedFeatures).forEach(([key, value]) => {
      params.append(key, value);
    });

    fetch(window.ajaxurl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
      },
      body: new URLSearchParams({
        action: 'sky_sliders_set_settings',
        action_type: featuresType,
        _wpnonce: SkySlidersConfig.nonce,
        ...Object.fromEntries(params)
      }).toString()
    })
      .then(async (response) => {
        if (!response.ok) {
          const errorData = await response.json();
          console.error('Server responded with error:', errorData);
          Swal.fire({
            icon: 'error',
            title: errorData?.title || 'Error',
            text: errorData?.msg || 'An error occurred while updating feature settings.'
          });
          return;
        }
        const data = await response.json();
        if (data?.success) {
          triggerRefresh();
          const Toast = Swal.mixin({
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer);
              toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
          });
          Toast.fire({
            icon: 'success',
            title: data?.data?.title,
            text: data?.data?.msg
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: data?.data?.title || 'Error',
            text: data?.data?.msg || 'An error occurred while updating feature settings.'
          });
        }
      })
      .catch((error) => {
        console.error('Error updating feature settings:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'An error occurred while updating feature settings.'
        });
      });
  };

  const ItemCard = ({ data }) => {
    const [isChecked, setIsChecked] = useState(data.value === "on");

    const handleSwitchChange = () => {
      if (data.feature_type === 'pro' && !SkySlidersConfig?.pro_init) {
        Swal.fire({
          icon: 'warning',
          title: __('Pro Feature', 'sky-sliders'),
          text: __('This is a Pro feature. Please activate Pro to use this feature.', 'sky-sliders')
        });
        return;
      }

      setIsChecked(!isChecked);
      setTimeout(() => {
        //update the data value
        const updatedFeatures = {};
        updatedFeatures[data.name] = !isChecked ? "on" : "off";
        // console.log('Updated feature:', updatedFeatures);

        setFeatures((prevFeatures) => {
          const updatedFeatures = prevFeatures.map((feature) => {
            if (feature.name === data.name) {
              return { ...feature, value: !isChecked ? "on" : "off" };
            }
            return feature;
          });
          return updatedFeatures;
        });
      }, 1000);

      // Delay request to avoid multiple requests at once
      clearTimeout(window.featureUpdateTimeout);
      window.featureUpdateTimeout = setTimeout(() => {
        // console.log('Submitting form...');
        formRef.current.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
      }, 2000); // Delay request by 1000ms to batch updates
    };

    let badgeValue = data?.content_type?.includes('new') ? 'New' : false;
    const badge = ('pro' !== data?.feature_type ? badgeValue : (SkySlidersConfig?.pro_init ? badgeValue : 'Pro'));

    return (
      <div className="sky-widgets-items w-100 px-5 py-4 flex items-center gap-3 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 relative overflow-hidden"
        data-used-status={data?.total_used > 0 ? 'used' : 'unused'}
        data-widget-type={data?.feature_type}
      >
        {badge && (
          <div className="absolute left-0 top-0 h-16 w-16">
            <div
              className="absolute transform -rotate-45 text-center text-white text-xs font-semibold py-1 left-[-64px] top-[8px] w-[170px] bg-gradient-to-r from-[#e052bd] via-[#8445a2] to-[#8441a4]">
              {badge}
            </div>
          </div>
        )}
        <div className="ss-icon-wrap text-5xl text-[#8441A4] bg-[#ebcff926] p-2.5 rounded-md dark:text-white">
          <i className={`sky-sliders-icon--${data.name}`}></i>
        </div>
        <div className="flex flex-col">
          <h6 className="text-l font-medium text-gray-800 dark:text-white leading-[1.3] mb-1">
            <a href={data?.demo_url} target="_blank" rel="noreferrer" className="hover:text-[#8441A4]" title="Click to view demo">
              {data.label}
            </a>
          </h6>
          {'get_extensions' !== featuresType && (
            <p className="text-gray-500 dark:text-gray-300">
              Used - <strong>{data?.total_used < 10 && data?.total_used > 0 ? `0${data?.total_used}` : data?.total_used}</strong> times
            </p>
          )}
        </div>
        <div className="flex items-center ml-auto mr-0">
          <label htmlFor={`switch-${data.name}`}>
            <input type="hidden" value="off" name={`${data.name}`}></input>
            <Switch
              checked={'pro' !== data?.feature_type ? isChecked : (SkySlidersConfig?.pro_init && isChecked ? isChecked : false)}
              onChange={handleSwitchChange}
              onColor="#b47fcc"
              onHandleColor="#8441A4"
              handleDiameter={30}
              uncheckedIcon={false}
              checkedIcon={false}
              boxShadow="0px 1px 5px rgba(0, 0, 0, 0.6)"
              height={18}
              width={48}
              className="react-switch"
              id={`switch-${data.name}`}
              name={`${data.name}`}
            />
          </label>
        </div>
      </div>
    );
  }

  return (

    <form method="post" name={`sky-sliders-${featuresType}`} onSubmit={submitForm} ref={formRef}>
      <div className='flex flex-col md:flex-row w-100 mb-5 gap-3 md:justify-between'>
        <div className="flex flex-wrap gap-2">
          <button type="button" className="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-1.5 rounded-md dark:bg-blue-900 dark:text-blue-300 hover:bg-blue-200 whitespace-nowrap"
            onClick={() => {
              setVisibleFilter("all");
              const usedItems = document.querySelectorAll('.sky-widgets-items[data-used-status="used"]');
              const unusedItems = document.querySelectorAll('.sky-widgets-items[data-used-status="unused"]');
              usedItems.forEach(item => {
                item.style.display = 'flex';
              });
              unusedItems.forEach(item => {
                item.style.display = 'flex';
              });
            }
            }
          >
            <FontAwesomeIcon icon={faCheck} className="me-1" />
            All
            <span className="ms-1">({countUsed + countUnused})</span>
          </button>
          {featuresType !== 'get_extensions' && (
            <>
              <button type="button" className="bg-green-100 text-green-800 text-sm font-medium px-2.5 py-1.5 rounded-md dark:bg-green-900 dark:text-green-300 hover:bg-green-200 whitespace-nowrap"
                onClick={() => {
                  setVisibleFilter("used");
                  const usedItems = document.querySelectorAll('.sky-widgets-items[data-used-status="used"]');
                  const unusedItems = document.querySelectorAll('.sky-widgets-items[data-used-status="unused"]');

                  if (usedItems.length > 0) {
                    unusedItems.forEach(item => {
                      item.style.display = 'none';
                    });
                    usedItems.forEach(item => {
                      item.style.display = 'flex';
                    });
                  }
                }}
              >
                <FontAwesomeIcon icon={faClock} className="me-1" />
                Used
                <span className="ms-1">({countUsed})</span>
              </button>
              <button type="button" className="bg-red-100 text-red-800 text-sm font-medium px-2.5 py-1.5 rounded-md dark:bg-red-900 dark:text-red-300 hover:bg-red-200 whitespace-nowrap"
                onClick={() => {
                  setVisibleFilter("unused");
                  const usedItems = document.querySelectorAll('.sky-widgets-items[data-used-status="used"]');
                  const unusedItems = document.querySelectorAll('.sky-widgets-items[data-used-status="unused"]');

                  if (unusedItems.length > 0) {
                    usedItems.forEach(item => {
                      item.style.display = 'none';
                    });
                    unusedItems.forEach(item => {
                      item.style.display = 'flex';
                    });
                  }
                }}
              >
                <FontAwesomeIcon icon={faCopy} className="me-1" />
                Unused
                <span className="ms-1">({countUnused})</span>
              </button>
            </>
          )}
        </div>
        <div className="flex flex-wrap gap-2 items-center">
          <input
            type="search"
            className="w-full sm:w-[130px] border border-gray-200 text-sm font-medium px-2.5 py-1.5 rounded-md dark:border-gray-700 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-300 dark:bg-gray-800"
            placeholder={__('Search ...', 'sky-sliders')}
            value={searchValue}
            onChange={handleSearch}
          />
          <button
            className="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-1.5 rounded-md dark:bg-blue-900 dark:text-blue-300 hover:bg-blue-200 whitespace-nowrap"
            onClick={() => toggleAllFeatures(true)}
          >
            <FontAwesomeIcon icon={faCheckDouble} className="me-1" />
            {__('Enable All', 'sky-sliders')}
          </button>
          <button
            className="bg-red-100 text-red-800 text-sm font-medium px-2.5 py-1.5 rounded-md dark:bg-red-900 dark:text-red-300 hover:bg-red-200 whitespace-nowrap"
            onClick={() => toggleAllFeatures(false)}
          >
            <FontAwesomeIcon icon={faTrash} className="me-1" />
            {__('Disable All', 'sky-sliders')}
          </button>
        </div>
      </div>

      {isSearchEmpty && (
        <div className="text-center text-gray-500 dark:text-gray-300 mt-5">
          {__('Sorry, not found. Please contact support for more information.', 'sky-sliders')}
        </div>
      )}

      <div className="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        {features
          .filter((feature) => {
            const matchesSearch = feature.label.toLowerCase().includes(searchValue);
            const matchesFilter =
              visibleFilter === "all" ||
              (visibleFilter === "used" && feature.total_used > 0) ||
              (visibleFilter === "unused" && feature.total_used === 0);
            return matchesSearch && matchesFilter;
          })
          .map((feature, index) => (
            <ItemCard key={index} data={feature} />
          ))}
      </div>
      {/* Always include all features as hidden inputs to ensure full settings are submitted */}
      {features.map((feature) => (
        <input
          key={`hidden-${feature.name}`}
          type="hidden"
          name={feature.name}
          value={feature.value}
        />
      ))}
      <button type="submit" className="hidden">Submit</button>
    </form>
  );
};

export default RenderFeatures;
