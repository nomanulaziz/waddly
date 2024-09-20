import './bootstrap';

//This is a special function provided by the Vite bundler
// that allows you to dynamically import files based on a pattern.
import.meta.glob([
    '../images/**'
]);