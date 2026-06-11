/**
 * Zero Nine Coffee Shop — Landing Page 3D Experience
 * Three.js Coffee Cup Hero + GSAP ScrollTrigger Animations
 */

import * as THREE from 'three';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

// ── Initialize only when landing page is present ──────────
if (document.getElementById('hero-canvas')) {
    initHero3D();
    initScrollAnimations();
    initParallax();
}

// ── 3D Coffee Cup Hero ────────────────────────────────────
function initHero3D() {
    const canvas = document.getElementById('hero-canvas');
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(45, canvas.clientWidth / canvas.clientHeight, 0.1, 100);
    camera.position.set(0, 0, 5);

    const renderer = new THREE.WebGLRenderer({
        canvas,
        alpha: true,
        antialias: true,
    });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.setSize(canvas.clientWidth, canvas.clientHeight);

    // ── Lighting ──
    const ambientLight = new THREE.AmbientLight(0xC5A880, 0.4);
    scene.add(ambientLight);

    const pointLight = new THREE.PointLight(0xFFF8F0, 1.5, 10);
    pointLight.position.set(2, 3, 4);
    scene.add(pointLight);

    const rimLight = new THREE.PointLight(0xC5A880, 0.8, 10);
    rimLight.position.set(-3, -1, -2);
    scene.add(rimLight);

    // ── Coffee Cup Geometry (procedural — no heavy 3D file) ──
    const cupGroup = new THREE.Group();

    // Cup body — truncated cylinder
    const cupGeometry = new THREE.CylinderGeometry(0.7, 0.5, 1.2, 32, 1, true);
    const cupMaterial = new THREE.MeshStandardMaterial({
        color: 0x3E2723,
        roughness: 0.3,
        metalness: 0.6,
        side: THREE.DoubleSide,
    });
    const cup = new THREE.Mesh(cupGeometry, cupMaterial);
    cupGroup.add(cup);

    // Cup bottom
    const bottomGeometry = new THREE.CircleGeometry(0.5, 32);
    const bottom = new THREE.Mesh(bottomGeometry, cupMaterial);
    bottom.rotation.x = -Math.PI / 2;
    bottom.position.y = -0.6;
    cupGroup.add(bottom);

    // Coffee surface (liquid)
    const coffeeGeometry = new THREE.CircleGeometry(0.68, 32);
    const coffeeMaterial = new THREE.MeshStandardMaterial({
        color: 0x2E1C12,
        roughness: 0.8,
        metalness: 0.1,
    });
    const coffeeSurface = new THREE.Mesh(coffeeGeometry, coffeeMaterial);
    coffeeSurface.rotation.x = -Math.PI / 2;
    coffeeSurface.position.y = 0.55;
    cupGroup.add(coffeeSurface);

    // Crema ring on coffee surface
    const cremaGeometry = new THREE.RingGeometry(0.2, 0.65, 48);
    const cremaMaterial = new THREE.MeshStandardMaterial({
        color: 0xC5A880,
        roughness: 0.9,
        metalness: 0.0,
        transparent: true,
        opacity: 0.7,
    });
    const crema = new THREE.Mesh(cremaGeometry, cremaMaterial);
    crema.rotation.x = -Math.PI / 2;
    crema.position.y = 0.56;
    cupGroup.add(crema);

    // Handle
    const handleCurve = new THREE.CatmullRomCurve3([
        new THREE.Vector3(0.7, 0.2, 0),
        new THREE.Vector3(1.3, 0.2, 0),
        new THREE.Vector3(1.3, -0.3, 0),
        new THREE.Vector3(0.7, -0.3, 0),
    ]);
    const handleGeometry = new THREE.TubeGeometry(handleCurve, 20, 0.06, 8, false);
    const handleMaterial = new THREE.MeshStandardMaterial({
        color: 0x3E2723,
        roughness: 0.3,
        metalness: 0.6,
    });
    const handle = new THREE.Mesh(handleGeometry, handleMaterial);
    cupGroup.add(handle);

    // Saucer
    const saucerGeometry = new THREE.CylinderGeometry(1.0, 0.9, 0.08, 32);
    const saucerMaterial = new THREE.MeshStandardMaterial({
        color: 0x4E342E,
        roughness: 0.2,
        metalness: 0.7,
    });
    const saucer = new THREE.Mesh(saucerGeometry, saucerMaterial);
    saucer.position.y = -0.7;
    cupGroup.add(saucer);

    scene.add(cupGroup);

    // ── Floating Coffee Beans (particles) ──
    const beanCount = 60;
    const beanPositions = new Float32Array(beanCount * 3);
    const beanSizes = new Float32Array(beanCount);

    for (let i = 0; i < beanCount; i++) {
        beanPositions[i * 3] = (Math.random() - 0.5) * 10;
        beanPositions[i * 3 + 1] = (Math.random() - 0.5) * 10;
        beanPositions[i * 3 + 2] = (Math.random() - 0.5) * 5;
        beanSizes[i] = Math.random() * 3 + 1;
    }

    const beanGeometry = new THREE.BufferGeometry();
    beanGeometry.setAttribute('position', new THREE.BufferAttribute(beanPositions, 3));
    beanGeometry.setAttribute('size', new THREE.BufferAttribute(beanSizes, 1));

    const beanMaterial = new THREE.PointsMaterial({
        color: 0x6F4E37,
        size: 0.05,
        transparent: true,
        opacity: 0.6,
        sizeAttenuation: true,
    });

    const beans = new THREE.Points(beanGeometry, beanMaterial);
    scene.add(beans);

    // ── Mouse interaction ──
    let mouseX = 0;
    let mouseY = 0;

    document.addEventListener('mousemove', (e) => {
        mouseX = (e.clientX / window.innerWidth - 0.5) * 2;
        mouseY = (e.clientY / window.innerHeight - 0.5) * 2;
    });

    // ── GSAP entry animation ──
    gsap.from(cupGroup.rotation, {
        y: -Math.PI * 2,
        duration: 2,
        ease: 'power3.out',
    });

    gsap.from(cupGroup.position, {
        y: -3,
        duration: 1.5,
        ease: 'power3.out',
    });

    // ── Scroll-driven rotation ──
    ScrollTrigger.create({
        trigger: '#hero-section',
        start: 'top top',
        end: 'bottom top',
        scrub: 1.5,
        onUpdate: (self) => {
            cupGroup.rotation.y = self.progress * Math.PI * 0.8;
            cupGroup.position.y = self.progress * -1.5;
        },
    });

    // ── Render loop ──
    const clock = new THREE.Clock();

    function animate() {
        requestAnimationFrame(animate);
        const elapsed = clock.getElapsedTime();

        // Smooth mouse-based tilt
        cupGroup.rotation.x += (mouseY * 0.3 - cupGroup.rotation.x) * 0.05;
        cupGroup.rotation.y += (mouseX * 0.5 - cupGroup.rotation.y) * 0.03;

        // Beans slowly drift
        beans.rotation.y = elapsed * 0.03;
        beans.rotation.x = elapsed * 0.01;

        // Crema shimmer
        crema.rotation.z = elapsed * 0.2;

        renderer.render(scene, camera);
    }

    animate();

    // ── Resize handler ──
    window.addEventListener('resize', () => {
        const w = canvas.clientWidth;
        const h = canvas.clientHeight;
        camera.aspect = w / h;
        camera.updateProjectionMatrix();
        renderer.setSize(w, h);
    });
}

// ── GSAP Section Scroll Animations ────────────────────────
function initScrollAnimations() {
    // Reveal elements on scroll
    gsap.utils.toArray('[data-reveal]').forEach((el) => {
        gsap.fromTo(el,
            { opacity: 0, y: 50 },
            {
                opacity: 1,
                y: 0,
                duration: 0.9,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: el,
                    start: 'top 85%',
                    toggleActions: 'play none none reverse',
                },
            }
        );
    });

    // Stagger reveal for grid items
    gsap.utils.toArray('[data-stagger]').forEach((container) => {
        const items = container.querySelectorAll('[data-stagger-item]');
        gsap.fromTo(items,
            { opacity: 0, y: 40, scale: 0.95 },
            {
                opacity: 1,
                y: 0,
                scale: 1,
                duration: 0.7,
                stagger: 0.12,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: container,
                    start: 'top 80%',
                },
            }
        );
    });

    // Counter animation for stats
    gsap.utils.toArray('[data-count]').forEach((el) => {
        const target = parseInt(el.dataset.count);
        gsap.fromTo({ val: 0 },
            { val: target },
            {
                val: target,
                duration: 2,
                ease: 'power2.out',
                snap: { val: 1 },
                onUpdate: function () {
                    el.textContent = Math.round(this.targets()[0].val).toLocaleString('id-ID');
                },
                scrollTrigger: {
                    trigger: el,
                    start: 'top 80%',
                    once: true,
                },
            }
        );
    });
}

// ── Parallax Layers ────────────────────────────────────────
function initParallax() {
    gsap.utils.toArray('[data-parallax]').forEach((el) => {
        const speed = parseFloat(el.dataset.parallax) || 0.3;
        gsap.to(el, {
            yPercent: speed * -100,
            ease: 'none',
            scrollTrigger: {
                trigger: el.parentElement,
                start: 'top bottom',
                end: 'bottom top',
                scrub: true,
            },
        });
    });
}
