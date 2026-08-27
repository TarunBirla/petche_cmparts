<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function show($slug)
    {
        $pageQuery = Page::where('is_active', true);
        
        if (in_array($slug, ['delivery', 'delivery-and-returns'])) {
            $pageQuery->whereIn('slug', ['delivery', 'delivery-and-returns']);
        } else {
            $pageQuery->where('slug', $slug);
        }
        
        $page = $pageQuery->first();

        if (!$page) {
            $page = Page::where('is_active', true)->where('title', 'like', "%delivery%")->firstOrFail();
        }

        return view('frontend.pages.show', compact('page'));
    }

    public function showContact()
    {
        return view('frontend.pages.contact');
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $contact = ContactMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject ?? 'General Contact Inquiry',
            'message' => $request->message,
        ]);

        // Send email alert to Admin (sales@petchemparts.com)
        try {
            Mail::to('sales@petchemparts.com')->send(new \App\Mail\ContactMessageAdminMail($contact));
        } catch (\Exception $e) {
            Log::error('Failed sending contact email alert to admin: ' . $e->getMessage());
        }

        // Send email confirmation to Customer
        try {
            Mail::to($contact->email)->send(new \App\Mail\ContactMessageCustomerMail($contact));
        } catch (\Exception $e) {
            Log::error('Failed sending contact email confirmation to customer: ' . $e->getMessage());
        }

        return back()->with('success', 'Thank you for reaching out to Petchemparts! Your message has been received and our team will get back to you shortly.');
    }
}
