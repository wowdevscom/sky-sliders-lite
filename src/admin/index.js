import { createRoot } from 'react-dom/client';

/**
 * Import the stylesheet for the plugin.
 */
import './style/_import.css';
import './style/_override.scss';
import './style/app.scss';

import { AppProvider } from './components/includes/AppContext';
import ErrorBoundary from './components/includes/ErrorBoundary';
import Dashboard from './Dashboard';

/**
 * Render the App component into the DOM
 */
const container = document.getElementById('sky-sliders');

if (container) {
    /**
     * Guard: SkySlidersConfig is injected by wp_localize_script.
     * Caching plugins can strip the inline script block, making this global
     * undefined and crashing the entire React app on property access.
     */
    if (typeof window.SkySlidersConfig === 'undefined') {
        container.innerHTML =
            '<div style="padding:2rem;color:#b91c1c;background:#fef2f2;border:1px solid #fca5a5;border-radius:8px;margin:1rem 0;">' +
            '<strong>Sky Sliders could not load.</strong> ' +
            'The configuration data is missing — this is usually caused by a caching plugin serving a stale page. ' +
            'Please clear your site cache and reload this page.' +
            '</div>';
    } else {
        const App = () => (
            <>
                <h2 className='app-title'></h2>
                <Dashboard />
            </>
        );

        const root = createRoot(container);
        root.render(
            <ErrorBoundary>
                <AppProvider>
                    <App />
                </AppProvider>
            </ErrorBoundary>
        );
    }
}
