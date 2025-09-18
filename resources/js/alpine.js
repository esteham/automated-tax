import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';

// Only initialize if not already initialized
if (!window.Alpine) {
    window.Alpine = Alpine;
    
    // Initialize plugins
    Alpine.plugin(focus);
    
    // Start Alpine.js when the page loads
    document.addEventListener('DOMContentLoaded', () => {
        if (!document.__alpineStarted) {
            Alpine.start();
            document.__alpineStarted = true;
        }
    });
}

export { Alpine };
