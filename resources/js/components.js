/**
 * Cireng Rujak - All Inline Scripts Externalized
 * This file contains all JavaScript that was previously inline
 */
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

// ===== UTILITY FUNCTIONS =====

/**
 * Copy text to clipboard
 * @param {string} text - Text to copy
 * @param {HTMLElement} btn - Button element
 */
function copyText(text, btn) {
    navigator.clipboard.writeText(text).then(() => {
        const original = btn.textContent;
        btn.textContent = '✓ Disalin!';
        btn.classList.add('bg-green-100', 'text-green-700', 'border-green-300');
        btn.classList.remove('text-orange-600', 'border-orange-200');
        setTimeout(() => {
            btn.textContent = original;
            btn.classList.remove('bg-green-100', 'text-green-700', 'border-green-300');
            btn.classList.add('text-orange-600', 'border-orange-200');
        }, 2000);
    }).catch(() => {
        // Fallback for older browsers
        const el = document.createElement('textarea');
        el.value = text;
        document.body.appendChild(el);
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);
        btn.textContent = '✓ Disalin!';
        setTimeout(() => { btn.textContent = 'Salin'; }, 2000);
    });
}

// ===== FILE UPLOAD FUNCTIONALITY =====

/**
 * Initialize file upload functionality
 */
function initFileUpload() {
    const fileInput = document.getElementById('payment_proof');
    const uploadArea = document.getElementById('upload-area');
    const fileInfo = document.getElementById('file-info');
    const fileName = document.getElementById('file-name');

    if (!fileInput || !uploadArea) return;

    fileInput.addEventListener('change', function(e) {
        if (this.files.length > 0) {
            const file = this.files[0];
            fileName.textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
            if (fileInfo) fileInfo.classList.remove('hidden');
            uploadArea.classList.add('border-green-400', 'bg-green-50');
            uploadArea.classList.remove('border-orange-300');
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

// ===== PAYMENT METHOD TABS =====

/**
 * Initialize payment method tabs
 */
function initPaymentTabs() {
    const tabs = document.querySelectorAll('.payment-tab');
    if (tabs.length === 0) return;

    const selectedMethodInput = document.getElementById('selected-payment-method');
    const selectedMethodLabel = document.getElementById('selected-method-label');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const method = this.getAttribute('data-method');
            const methodCode = this.getAttribute('data-method-code');
            const methodLabel = this.getAttribute('data-method-label');

            // Update tab styles
            tabs.forEach(t => {
                t.classList.remove('bg-orange-500', 'text-white', 'shadow-md', 'active-tab');
                t.classList.add('bg-white', 'text-gray-700', 'border', 'border-gray-200');
            });
            this.classList.add('bg-orange-500', 'text-white', 'shadow-md', 'active-tab');
            this.classList.remove('bg-white', 'text-gray-700', 'border', 'border-gray-200');

            // Show/hide panels
            document.querySelectorAll('.payment-panel').forEach(panel => {
                panel.classList.add('hidden');
            });
            const target = document.getElementById('panel-' + method);
            if (target) {
                target.classList.remove('hidden');
                target.style.animation = 'fadeIn 0.3s ease-out';
            }

            if (selectedMethodInput && methodCode) {
                selectedMethodInput.value = methodCode;
            }

            if (selectedMethodLabel && methodLabel) {
                selectedMethodLabel.textContent = methodLabel;
            }
        });
    });
}

/**
 * Initialize payment countdown timer
 */
function initPaymentCountdown() {
    const countdownElement = document.getElementById('payment-countdown');
    if (!countdownElement) return;

    const expiresAt = countdownElement.dataset.expiresAt;
    if (!expiresAt) {
        countdownElement.textContent = '--:--';
        return;
    }

    const expiresAtDate = new Date(expiresAt);

    const updateCountdown = () => {
        const now = new Date();
        const diffMs = expiresAtDate - now;

        if (diffMs <= 0) {
            countdownElement.textContent = '00:00';
            countdownElement.classList.add('text-red-600');
            return;
        }

        const minutes = Math.floor(diffMs / 60000);
        const seconds = Math.floor((diffMs % 60000) / 1000);
        countdownElement.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

        if (minutes < 5) {
            countdownElement.classList.add('text-red-600');
        }
    };

    updateCountdown();
    setInterval(updateCountdown, 1000);
}

// ===== ORDER SUMMARY CALCULATOR =====

const formatRupiah = (number) => {
    return 'Rp' + number.toLocaleString('id-ID');
};

/**
 * Update order summary in real-time
 */
function updateOrderSummary() {
    const inputs = document.querySelectorAll('input[data-price]');
    let total = 0;
    let summaryHTML = '';
    let hasItems = false;

    inputs.forEach(input => {
        const qty = parseInt(input.value) || 0;
        const price = parseFloat(input.getAttribute('data-price')) || 0;

        // Get product name - look for h4 in the parent container
        let productName = '';
        const parentContainer = input.closest('.flex.items-center');
        if (parentContainer) {
            const h4Element = parentContainer.querySelector('h4');
            if (h4Element && h4Element.textContent) {
                productName = h4Element.textContent.trim();
            }
        }

        if (qty > 0) {
            hasItems = true;
            const subtotal = qty * price;
            total += subtotal;

            summaryHTML += `
                <div class="flex justify-between items-start gap-2">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">${productName}</p>
                        <p class="text-xs text-gray-500">${qty} x ${formatRupiah(price)}</p>
                    </div>
                    <p class="text-sm font-bold text-orange-600 whitespace-nowrap">${formatRupiah(subtotal)}</p>
                </div>
            `;
        }
    });

    const summaryContainer = document.getElementById('order-summary');
    const subtotalEl = document.getElementById('subtotal');
    const totalEl = document.getElementById('total');

    if (hasItems) {
        if (summaryContainer) summaryContainer.innerHTML = summaryHTML;
    } else {
        if (summaryContainer) summaryContainer.innerHTML = '<p class="text-sm text-gray-500 italic">Belum ada produk dipilih</p>';
    }

    if (subtotalEl) subtotalEl.textContent = formatRupiah(total);
    if (totalEl) totalEl.textContent = formatRupiah(total);

    // Animate total update
    if (totalEl) {
        totalEl.classList.add('scale-110');
        setTimeout(() => totalEl.classList.remove('scale-110'), 200);
    }
}

/**
 * Initialize order quantity controls with +/- buttons
 */
function initOrderQuantityControls() {
    const inputs = document.querySelectorAll('input[data-price]');

    inputs.forEach(input => {
        // Skip if already initialized
        if (input.dataset.qtyInitialized) return;
        input.dataset.qtyInitialized = 'true';

        const wrapper = input.parentElement;
        if (!wrapper) return;

        // Create minus button
        const minusBtn = document.createElement('button');
        minusBtn.type = 'button';
        minusBtn.textContent = '−';
        minusBtn.className = 'qty-btn w-8 h-8 rounded-full bg-gray-100 hover:bg-orange-500 hover:text-white text-gray-700 font-bold text-lg flex items-center justify-center transition-all duration-200 border border-gray-200';
        minusBtn.addEventListener('click', () => {
            const current = parseInt(input.value) || 0;
            if (current > 0) {
                input.value = current - 1;
                updateOrderSummary();
            }
        });

        // Create plus button
        const plusBtn = document.createElement('button');
        plusBtn.type = 'button';
        plusBtn.textContent = '+';
        plusBtn.className = 'qty-btn w-8 h-8 rounded-full bg-orange-500 hover:bg-orange-600 text-white font-bold text-lg flex items-center justify-center transition-all duration-200';
        plusBtn.addEventListener('click', () => {
            const current = parseInt(input.value) || 0;
            input.value = current + 1;
            updateOrderSummary();
        });

        // Style the input
        input.className = 'w-14 px-2 py-2 border border-gray-200 rounded-lg text-center focus:border-orange-500 outline-none font-bold text-gray-900';

        // Insert buttons around input
        wrapper.insertBefore(minusBtn, input);
        wrapper.appendChild(plusBtn);
    });

    // Add event listeners to all quantity inputs
    inputs.forEach(input => {
        input.addEventListener('input', updateOrderSummary);
        input.addEventListener('change', updateOrderSummary);
    });

    // Initial call
    updateOrderSummary();
}

/**
 * Initialize form validation for order creation
 */
function initOrderFormValidation() {
    const form = document.getElementById('order-form');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        const inputs = document.querySelectorAll('input[data-price]');
        let hasItems = false;
        inputs.forEach(input => {
            if (parseInt(input.value) > 0) hasItems = true;
        });

        if (!hasItems) {
            e.preventDefault();
            alert('Pilih minimal 1 produk sebelum melanjutkan!');
        }
    });
}

// ===== DASHBOARD TABS =====

/**
 * Initialize dashboard order tabs
 */
function initDashboardTabs() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    if (tabButtons.length === 0) return;

    tabButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const tab = this.getAttribute('data-tab');

            // Update active tab
            tabButtons.forEach(b => {
                b.classList.remove('border-orange-500', 'text-orange-600');
                b.classList.add('text-gray-600');
                b.setAttribute('aria-selected', 'false');
            });
            this.classList.add('border-orange-500', 'text-orange-600');
            this.setAttribute('aria-selected', 'true');

            // Filter orders
            const items = document.querySelectorAll('.order-item');
            items.forEach(item => {
                const status = item.getAttribute('data-status');
                if (tab === 'all') {
                    item.style.display = 'block';
                } else if (tab === 'pending' && !['completed', 'cancelled'].includes(status)) {
                    item.style.display = 'block';
                } else if (tab === 'completed' && status === 'completed') {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
}

// ===== ADMIN SALES CHART =====

function formatCompactRupiah(value) {
    const abs = Math.abs(value);
    if (abs >= 1_000_000_000) return `Rp${(value / 1_000_000_000).toFixed(1)}M`;
    if (abs >= 1_000_000) return `Rp${(value / 1_000_000).toFixed(1)}jt`;
    if (abs >= 1_000) return `Rp${(value / 1_000).toFixed(0)}k`;
    return `Rp${value}`;
}

function initAdminSalesChart() {
    const canvas = document.getElementById('admin-sales-chart');
    if (!canvas) return;

    let trendData = [];
    try {
        trendData = JSON.parse(canvas.dataset.trend || '[]');
    } catch {
        trendData = [];
    }

    if (trendData.length === 0) return;

    const labels = trendData.map((item) => item.day_label);
    const revenues = trendData.map((item) => Number(item.revenue || 0));
    const orders = trendData.map((item) => Number(item.orders || 0));

    if (window.__adminSalesChart) {
        window.__adminSalesChart.destroy();
    }

    const ctx = canvas.getContext('2d');
    window.__adminSalesChart = new Chart(ctx, {
        data: {
            labels,
            datasets: [
                {
                    type: 'bar',
                    label: 'Omzet',
                    data: revenues,
                    yAxisID: 'yRevenue',
                    backgroundColor: 'rgba(249, 115, 22, 0.75)',
                    borderColor: 'rgba(249, 115, 22, 1)',
                    borderWidth: 1,
                    borderRadius: 6,
                    maxBarThickness: 28,
                },
                {
                    type: 'line',
                    label: 'Jumlah Order',
                    data: orders,
                    yAxisID: 'yOrders',
                    borderColor: 'rgba(37, 99, 235, 1)',
                    backgroundColor: 'rgba(37, 99, 235, 0.15)',
                    tension: 0.3,
                    pointRadius: 4,
                    pointHoverRadius: 5,
                    pointBackgroundColor: 'rgba(37, 99, 235, 1)',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 1.5,
                    fill: false,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    position: 'top',
                    align: 'start',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 8,
                        color: '#374151',
                        font: {
                            size: 12,
                            weight: 600,
                        },
                    },
                },
                tooltip: {
                    callbacks: {
                        label(context) {
                            if (context.dataset.label === 'Omzet') {
                                return `${context.dataset.label}: Rp${Number(context.raw || 0).toLocaleString('id-ID')}`;
                            }
                            return `${context.dataset.label}: ${context.raw} order`;
                        },
                    },
                },
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                    },
                    ticks: {
                        color: '#6B7280',
                        maxRotation: 0,
                        autoSkip: labels.length > 30,
                    },
                },
                yRevenue: {
                    type: 'linear',
                    position: 'left',
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(229, 231, 235, 0.8)',
                    },
                    ticks: {
                        color: '#9CA3AF',
                        callback(value) {
                            return formatCompactRupiah(Number(value));
                        },
                    },
                },
                yOrders: {
                    type: 'linear',
                    position: 'right',
                    beginAtZero: true,
                    grid: {
                        drawOnChartArea: false,
                    },
                    ticks: {
                        color: '#9CA3AF',
                        precision: 0,
                    },
                },
            },
        },
    });
}

// ===== EXPORT FUNCTIONS FOR REUSE =====

window.CirengApp = {
    copyText,
    updateOrderSummary,
    initFileUpload,
    initPaymentTabs,
    initPaymentCountdown,
    initOrderQuantityControls,
    initOrderFormValidation,
    initDashboardTabs,
    initAdminSalesChart
};

window.copyText = copyText;
