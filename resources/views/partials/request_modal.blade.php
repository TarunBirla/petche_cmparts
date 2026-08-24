<div id="request-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeRequestModal()"></div>

    <!-- Modal Dialog -->
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-sky-100">
            
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-sky-800 to-sky-600 px-6 py-3.5 text-white flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-clipboard-list text-xl text-sky-200"></i>
                    <div>
                        <h3 class="text-base font-bold">Product Quote Request</h3>
                        <p class="text-[11px] text-sky-100">Review selected industrial parts and submit your quotation inquiry.</p>
                    </div>
                </div>
                <button onclick="closeRequestModal()" class="text-white/80 hover:text-white text-xl font-bold p-1">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <!-- Empty State -->
                <div id="modal-empty-state" class="text-center py-8 hidden">
                    <div class="w-14 h-14 bg-sky-50 text-sky-500 rounded-full flex items-center justify-center mx-auto mb-3 text-xl">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <h4 class="font-semibold text-slate-700 text-sm">Your Request List is Empty</h4>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">Browse our industrial catalog and click "Add to Request" on any product to build your quote inquiry.</p>
                    <a href="{{ route('products.index') }}" onclick="closeRequestModal()" class="inline-block mt-3 bg-[var(--primary-dark)] hover:bg-sky-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">Browse Products</a>
                </div>

                <!-- Products Table & Form Container -->
                <div id="modal-content-state">
                    <!-- Products Table with Fixed 2-Item Height Scrollbar -->
                    <div class="mb-4 border rounded-xl overflow-hidden border-slate-200 shadow-sm bg-white">
                        <table class="w-full text-left text-xs text-slate-600">
                            <thead class="bg-sky-50 text-sky-900 font-semibold uppercase text-[10px] tracking-wider border-b">
                                <tr>
                                    <th class="p-2.5 w-5/12">Product</th>
                                    <th class="p-2.5 w-2/12">Part #</th>
                                    <th class="p-2.5 w-2/12">Price</th>
                                    <th class="p-2.5 w-1/12 text-center">Qty</th>
                                    <th class="p-2.5 w-2/12 text-right">Subtotal</th>
                                    <th class="p-2.5 w-1/12 text-center">Action</th>
                                </tr>
                            </thead>
                        </table>

                        <!-- Scrollable Container showing approx 2 products at a time -->
                        <div class="max-h-36 overflow-y-auto divide-y divide-slate-100 custom-scrollbar">
                            <table class="w-full text-left text-xs text-slate-600">
                                <tbody id="request-modal-items-list">
                                    <!-- Populated dynamically by JS -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Footer Total Row -->
                        <div class="bg-slate-50 font-semibold text-slate-800 border-t p-2.5 flex justify-between items-center text-xs">
                            <span class="text-slate-600">Total Estimated Value:</span>
                            <span id="modal-grand-total" class="text-sm text-sky-700 font-bold">£0.00</span>
                        </div>
                    </div>

                    <!-- Customer Contact Form -->
                    <form id="request-submit-form" onsubmit="handleRequestSubmit(event)">
                        <h4 class="font-bold text-xs uppercase tracking-wider text-sky-900 mb-2 flex items-center gap-1.5">
                            <i class="fa-solid fa-id-card text-sky-600"></i> Customer Information
                        </h4>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-2.5">
                            <div>
                                <label class="block text-[11px] font-medium text-slate-700 mb-1">Full Name <span class="text-rose-500">*</span></label>
                                <input type="text" id="req_customer_name" required placeholder="e.g. John Doe" class="w-full text-xs px-3 py-1.5 border rounded-lg border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-medium text-slate-700 mb-1">Email Address <span class="text-rose-500">*</span></label>
                                <input type="email" id="req_customer_email" required placeholder="name@company.com" class="w-full text-xs px-3 py-1.5 border rounded-lg border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-medium text-slate-700 mb-1">Phone Number <span class="text-rose-500">*</span></label>
                                <input type="tel" id="req_customer_phone" required placeholder="+44 7123 456789" class="w-full text-xs px-3 py-1.5 border rounded-lg border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="block text-[11px] font-medium text-slate-700 mb-1">Additional Requirements / Notes (Optional)</label>
                            <textarea id="req_notes" rows="2" placeholder="Specify targeted delivery timeframe, project details, or custom technical specs..." class="w-full text-xs px-3 py-1.5 border rounded-lg border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500"></textarea>
                        </div>

                        <!-- Alert Box for Submit Feedback -->
                        <div id="request-form-feedback" class="hidden mb-3 text-xs p-2.5 rounded-lg"></div>

                        <!-- Action Buttons -->
                        <div class="flex justify-between items-center pt-2.5 border-t border-slate-200">
                            <button type="button" onclick="clearAllRequests()" class="text-xs text-rose-600 hover:text-rose-800 font-medium">
                                <i class="fa-solid fa-trash-can mr-1"></i> Clear List
                            </button>

                            <div class="flex gap-2">
                                <button type="button" onclick="closeRequestModal()" class="px-4 py-2 text-xs font-medium text-slate-600 hover:bg-slate-100 rounded-lg transition">Close</button>
                                <button type="submit" id="submit-request-btn" class="px-5 py-2 bg-[var(--primary-dark)] hover:bg-sky-700 text-white text-xs font-bold rounded-lg shadow-md shadow-sky-200 transition flex items-center gap-2">
                                    <span>Submit Request</span>
                                    <i class="fa-solid fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    function openRequestModal() {
        renderModalItems();
        document.getElementById('request-modal').classList.remove('hidden');
    }

    function closeRequestModal() {
        document.getElementById('request-modal').classList.add('hidden');
    }

    function renderModalItems() {
        const items = getRequestItems();
        const emptyState = document.getElementById('modal-empty-state');
        const contentState = document.getElementById('modal-content-state');
        const itemsList = document.getElementById('request-modal-items-list');
        const grandTotalEl = document.getElementById('modal-grand-total');

        if (items.length === 0) {
            emptyState.classList.remove('hidden');
            contentState.classList.add('hidden');
            return;
        }

        emptyState.classList.add('hidden');
        contentState.classList.remove('hidden');

        let html = '';
        let grandTotal = 0;

        items.forEach((item, index) => {
            const subtotal = item.price * item.quantity;
            grandTotal += subtotal;
            const fallbackImg = "{{ asset('images/logo.jpg') }}";
            const itemImg = item.image ? "{{ asset('') }}" + item.image : fallbackImg;

            html += `
                <tr>
                    <td class="p-2.5 w-5/12">
                        <div class="flex items-center gap-2">
                            <img src="${itemImg}" alt="${item.name}" class="w-8 h-8 object-cover rounded border flex-shrink-0">
                            <span class="font-medium text-slate-800 line-clamp-1 text-xs" title="${item.name}">${item.name}</span>
                        </div>
                    </td>
                    <td class="p-2.5 w-2/12 text-slate-500 font-mono text-[11px]">${item.part_number || 'N/A'}</td>
                    <td class="p-2.5 w-2/12 font-medium">£${parseFloat(item.price).toFixed(2)}</td>
                    <td class="p-2.5 w-1/12 text-center">
                        <div class="inline-flex items-center border rounded border-slate-300 overflow-hidden">
                            <button type="button" onclick="updateQty(${index}, -1)" class="px-1.5 py-0.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-[10px] font-bold">-</button>
                            <span class="px-2 py-0.5 text-xs font-semibold">${item.quantity}</span>
                            <button type="button" onclick="updateQty(${index}, 1)" class="px-1.5 py-0.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-[10px] font-bold">+</button>
                        </div>
                    </td>
                    <td class="p-2.5 w-2/12 text-right font-bold text-sky-900">£${subtotal.toFixed(2)}</td>
                    <td class="p-2.5 w-1/12 text-center">
                        <button type="button" onclick="removeRequestItem(${index})" class="text-rose-500 hover:text-rose-700 p-1">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        itemsList.innerHTML = html;
        grandTotalEl.innerText = `£${grandTotal.toFixed(2)}`;
    }

    function updateQty(index, delta) {
        let items = getRequestItems();
        if (items[index]) {
            items[index].quantity += delta;
            if (items[index].quantity <= 0) {
                items.splice(index, 1);
            }
            saveRequestItems(items);
            renderModalItems();
        }
    }

    function removeRequestItem(index) {
        let items = getRequestItems();
        items.splice(index, 1);
        saveRequestItems(items);
        renderModalItems();
    }

    function clearAllRequests() {
        if (confirm('Are you sure you want to clear all items from your request list?')) {
            saveRequestItems([]);
            renderModalItems();
        }
    }

    async function handleRequestSubmit(e) {
        e.preventDefault();
        const items = getRequestItems();
        if (items.length === 0) return;

        const feedbackEl = document.getElementById('request-form-feedback');
        const submitBtn = document.getElementById('submit-request-btn');

        const payload = {
            customer_name: document.getElementById('req_customer_name').value,
            customer_email: document.getElementById('req_customer_email').value,
            customer_phone: document.getElementById('req_customer_phone').value,
            notes: document.getElementById('req_notes').value,
            items: items.map(i => ({ product_id: i.product_id, quantity: i.quantity }))
        };

        submitBtn.disabled = true;
        submitBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> Submitting...`;
        feedbackEl.className = 'hidden';

        try {
            const response = await fetch("{{ route('request.submit') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(payload)
            });

            const data = await response.json();

            if (response.ok && data.success) {
                feedbackEl.className = 'mb-3 text-xs p-3 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200 block';
                feedbackEl.innerHTML = `<i class="fa-solid fa-circle-check text-emerald-600 mr-1"></i> ${data.message} <strong>(Ref: ${data.request_number})</strong>`;
                
                // Clear storage
                saveRequestItems([]);
                setTimeout(() => {
                    closeRequestModal();
                    feedbackEl.className = 'hidden';
                    document.getElementById('request-submit-form').reset();
                }, 4000);
            } else {
                throw new Error(data.message || 'Submission failed.');
            }
        } catch (err) {
            feedbackEl.className = 'mb-3 text-xs p-3 rounded-lg bg-rose-50 text-rose-800 border border-rose-200 block';
            feedbackEl.innerHTML = `<i class="fa-solid fa-triangle-exclamation text-rose-600 mr-1"></i> ${err.message}`;
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = `<span>Submit Request</span> <i class="fa-solid fa-paper-plane"></i>`;
        }
    }
</script>
