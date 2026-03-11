import './bootstrap';
import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import AOS from 'aos';
import 'aos/dist/aos.css';
import './components.js';

// Initialize Alpine.js
Alpine.plugin(intersect);
window.Alpine = Alpine;
Alpine.start();

// Initialize AOS
document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        mirror: false
    });

    // Menu Filter Functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    const productItems = document.querySelectorAll('.product-item');
    const noResults = document.getElementById('no-results');

    if (filterButtons.length > 0) {
        filterButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const category = this.getAttribute('data-category');

                // Update active button
                filterButtons.forEach(b => {
                    b.classList.remove('bg-orange-500', 'text-white');
                    b.classList.add('bg-white', 'text-gray-700', 'border-2', 'border-gray-200');
                });
                this.classList.remove('bg-white', 'text-gray-700', 'border-2', 'border-gray-200');
                this.classList.add('bg-orange-500', 'text-white');

                // Filter products
                let visibleCount = 0;
                productItems.forEach((product, index) => {
                    if (category === 'all' || product.getAttribute('data-category') === category) {
                        product.style.display = 'block';
                        setTimeout(() => product.classList.add('animate-fadeIn'), index * 50);
                        visibleCount++;
                    } else {
                        product.style.display = 'none';
                        product.classList.remove('animate-fadeIn');
                    }
                });

                // Show/hide no results
                if (noResults) {
                    if (visibleCount === 0) {
                        noResults.classList.remove('hidden');
                    } else {
                        noResults.classList.add('hidden');
                    }
                }
            });
        });
    }

    // Order Summary Live Update
    const quantityInputs = document.querySelectorAll('input[data-product-id]');
    if (quantityInputs.length > 0) {
        function updateOrderSummary() {
            let subtotal = 0;
            let itemCount = 0;
            const summary = document.getElementById('order-summary');
            let summaryHTML = '';

            quantityInputs.forEach(input => {
                const quantity = parseInt(input.value) || 0;
                if (quantity > 0) {
                    const price = parseInt(input.getAttribute('data-price')) || 0;
                    const itemTotal = price * quantity;
                    subtotal += itemTotal;
                    itemCount++;

                    // Safely get product name
                    let productName = 'Produk';
                    const parentFlex = input.closest('.flex');
                    if (parentFlex) {
                        const h4Element = parentFlex.querySelector('h4');
                        if (h4Element && h4Element.textContent) {
                            productName = h4Element.textContent.trim();
                        }
                    }

                    summaryHTML += `
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">${productName} x${quantity}</span>
                            <span class="font-medium text-gray-900">Rp${itemTotal.toLocaleString('id-ID')}</span>
                        </div>
                    `;
                }
            });

            if (itemCount === 0) {
                summaryHTML = '<p class="text-sm text-gray-600">Pesanan akan muncul di sini</p>';
            }

            if (summary) {
                summary.innerHTML = summaryHTML;
                const subtotalEl = document.getElementById('subtotal');
                const totalEl = document.getElementById('total');
                if (subtotalEl) subtotalEl.textContent = `Rp${subtotal.toLocaleString('id-ID')}`;
                if (totalEl) totalEl.textContent = `Rp${subtotal.toLocaleString('id-ID')}`;
            }
        }

        quantityInputs.forEach(input => {
            input.addEventListener('change', updateOrderSummary);
            input.addEventListener('input', updateOrderSummary);
        });

        // Initial call
        updateOrderSummary();
    }

    // File Upload Preview for Payment
    const fileInput = document.getElementById('payment_proof');
    const uploadArea = document.getElementById('upload-area');
    const fileInfo = document.getElementById('file-info');
    const fileName = document.getElementById('file-name');

    if (fileInput && uploadArea) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                fileName.textContent = file.name;
                fileInfo.classList.remove('hidden');
            }
        });

        // Drag and drop
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('border-orange-500', 'bg-orange-50');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('border-orange-500', 'bg-orange-50');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('border-orange-500', 'bg-orange-50');
            fileInput.files = e.dataTransfer.files;
            const event = new Event('change', { bubbles: true });
            fileInput.dispatchEvent(event);
        });
    }
});

