import { createRoot, render } from '@wordpress/element';
import './app.css';
import App from './app';

const root = document.getElementById('wpui-sample-plugin');

if (createRoot) {
    createRoot(root).render(<App />);
} else {
    render(<App />, root);
}
