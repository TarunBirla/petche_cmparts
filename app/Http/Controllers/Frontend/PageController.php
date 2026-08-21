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
        $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();
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

        // Send email alert to Admin
        try {
            $adminEmail = config('mail.from.address', 'Sales@petchemparts.com');
            Mail::raw("New Contact Inquiry Received from {$contact->name} ({$contact->email}):\n\nSubject: {$contact->subject}\nPhone: {$contact->phone}\n\nMessage:\n{$contact->message}", function ($mail) use ($adminEmail, $contact) {
                $mail->to($adminEmail)
                     ->subject('New Contact Inquiry: ' . $contact->subject);
            });
        } catch (\Exception $e) {
            Log::error('Failed sending contact email alert: ' . $e->getMessage());
        }

        return back()->with('success', 'Thank you for reaching out to Petchemparts! Your message has been received and our team will get back to you shortly.');
    }
}
