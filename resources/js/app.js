import './bootstrap';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

// Livewire 3 handles Alpine initialization automatically.
// If you need to interact with Alpine, use document.addEventListener('livewire:init')
