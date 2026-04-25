import React from "react";
import { __ } from "@wordpress/i18n";

class ErrorBoundary extends React.Component {
  constructor(props) {
    super(props);
    this.state = { hasError: false };
  }

  static getDerivedStateFromError(error) {
    return { hasError: true };
  }

  componentDidCatch(error, errorInfo) {
    console.error("ErrorBoundary caught an error:", error, errorInfo);
  }

  render() {
    if (this.state.hasError) {
      return (
        <div className="p-4 text-center bg-red-100 text-red-700 rounded-lg">
          <h2>{__('Something went wrong.', 'sky-sliders')}</h2>
          <p>{__('Please clear your site cache and reload the page.', 'sky-sliders')}</p>
          <button
            onClick={() => window.location.reload()}
            className="mt-3 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
          >
            {__('Reload Page', 'sky-sliders')}
          </button>
        </div>
      );
    }

    return this.props.children;
  }
}

export default ErrorBoundary;
