import React, { Suspense } from "react";
import { __ } from "@wordpress/i18n";
import ErrorBoundary from "./includes/ErrorBoundary";
import Sidebar from "./includes/Sidebar";

import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faBars } from "@fortawesome/free-solid-svg-icons";

const DashboardLayout = ({
  data,
  activeTab,
  onTabClick,
  isSidebarOpen,
  toggleSidebar,
  isLargeScreen,
}) => {
  // Toggle button for small screens that appears in content area
  const SmallScreenToggle = () => {
    if (isLargeScreen) return null;

    return (
      <button
        className="mb-4 bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-4 py-2.5 rounded-lg flex items-center gap-3 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50"
        onClick={toggleSidebar}
      >
        <div className={`transition-all duration-300 ${isSidebarOpen ? "" : "rotate-180"}`}>
          <FontAwesomeIcon icon={faBars} className="h-5 w-5" />
        </div>
        <span className="font-medium">
          {isSidebarOpen ? __('Hide Menu', 'sky-sliders') : __('Show Menu', 'sky-sliders')}
        </span>
      </button>
    );
  };
  return (
    <div className="flex flex-col xl:flex-row gap-4 my-4 lg:my-6">
      <Sidebar
        data={data}
        activeTab={activeTab}
        onTabClick={onTabClick}
        isSidebarOpen={isSidebarOpen}
        toggleSidebar={toggleSidebar}
        isLargeScreen={isLargeScreen}
      />
      <div className="flex-1 w-full h-max text-gray-700 antialiased font-sans text-base font-light leading-relaxed py-0 rounded-lg overflow-hidden">
        <SmallScreenToggle />
        {data.map(({ value, desc }) => (
          <div
            key={value}
            className={`py-0 ${activeTab === value ? "block" : "hidden"}`}
          >
            <ErrorBoundary>
              <Suspense fallback={<div>{__('Loading...', 'sky-sliders')}</div>}>
                {desc}
              </Suspense>
            </ErrorBoundary>
          </div>
        ))}
      </div>
    </div>
  );
};

export default DashboardLayout;
