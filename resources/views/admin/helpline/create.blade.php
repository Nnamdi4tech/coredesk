{{-- resources/views/admin/helpline/create.blade.php --}}
@extends('layouts.admin')

@section('content')
@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('tenant.helpline.index', $subdomain) }}" class="text-slate-400 hover:text-slate-600">
            <i class="fa fa-arrow-left"></i>
        </a>
        <h3 class="text-2xl font-bold text-slate-700">Create Support Ticket</h3>
    </div>

    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h6 class="font-bold text-slate-700">Ticket Information</h6>
            <p class="text-xs text-slate-400 mt-0.5">Fill out the form below to create a support ticket</p>
        </div>

        <form method="POST" action="{{ route('tenant.helpline.store', $subdomain) }}" class="p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Subject --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        Subject <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="subject" required 
                           placeholder="Brief summary of your issue"
                           class="w-full text-sm rounded-lg border border-gray-200 py-2.5 px-3 focus:outline-none focus:border-blue-300">
                </div>

                {{-- Category --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select name="category" required class="w-full text-sm rounded-lg border border-gray-200 py-2.5 px-3">
                        <option value="general">📋 General Question</option>
                        <option value="bug">🐛 Bug Report</option>
                        <option value="feature_request">💡 Feature Request</option>
                        <option value="billing">💰 Billing Issue</option>
                        <option value="technical">🔧 Technical Help</option>
                    </select>
                </div>

                {{-- Priority --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        Priority <span class="text-red-500">*</span>
                    </label>
                    <select name="priority" required class="w-full text-sm rounded-lg border border-gray-200 py-2.5 px-3">
                        <option value="low">🟢 Low - Not urgent</option>
                        <option value="medium">🟡 Medium - Normal priority</option>
                        <option value="high">🟠 High - Important</option>
                        <option value="urgent">🔴 Urgent - Critical issue</option>
                    </select>
                </div>

                {{-- Message --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        Message <span class="text-red-500">*</span>
                    </label>
                    <textarea name="message" rows="6" required 
                              placeholder="Please describe your issue in detail..."
                              class="w-full text-sm rounded-lg border border-gray-200 py-2.5 px-3 focus:outline-none focus:border-blue-300"></textarea>
                </div>

                {{-- Contact Phone --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Phone Number</label>
                    <input type="tel" name="contact_phone" 
                           placeholder="e.g., 08012345678"
                           class="w-full text-sm rounded-lg border border-gray-200 py-2.5 px-3">
                </div>

                {{-- Contact Email --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Email Address</label>
                    <input type="email" name="contact_email" 
                           value="{{ auth()->user()->email }}"
                           class="w-full text-sm rounded-lg border border-gray-200 py-2.5 px-3">
                </div>

                {{-- Preferred Contact --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Preferred Contact Method</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="preferred_contact" value="email" checked> 
                            <span class="text-sm">📧 Email</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="preferred_contact" value="phone"> 
                            <span class="text-sm">📞 Phone</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="preferred_contact" value="whatsapp"> 
                            <span class="text-sm">💬 WhatsApp</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <a href="{{ route('tenant.helpline.index', $subdomain) }}"
                   class="px-6 py-2.5 text-sm font-semibold text-slate-600 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2.5 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                    <i class="fa fa-paper-plane mr-1"></i> Submit Ticket
                </button>
            </div>
        </form>
    </div>

    {{-- Emergency Contact --}}
    <div class="mt-6 p-4 bg-red-50 rounded-xl border border-red-100">
        <div class="flex items-center gap-3">
            <i class="fa fa-exclamation-triangle text-red-500 text-xl"></i>
            <div>
                <p class="text-sm font-semibold text-red-800">Emergency/Critical Issue?</p>
                <p class="text-xs text-red-600">For urgent matters, please call us directly: 
                    <a href="tel:+2348137159867" class="font-bold underline">+234 813 715 9867</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection