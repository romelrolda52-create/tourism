<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedbacks = \App\Models\Feedback::with(['booking', 'repliedBy'])->latest()->paginate(10);
        return view('feedback.index', compact('feedbacks'));
    }

    /**
     * Show form to reply to feedback
     */
    public function reply(Feedback $feedback)
    {
        return view('feedback.reply', compact('feedback'));
    }

    /**
     * Store admin reply
     */
    public function storeReply(Request $request, Feedback $feedback)
    {
        $request->validate([
            'admin_reply' => 'required|string|max:1000'
        ]);

        $feedback->update([
            'admin_reply' => $request->admin_reply,
            'replied_at' => now(),
            'replied_by' => auth()->id(),
        ]);

        return redirect()->route('feedback.index')
            ->with('success', 'Reply sent successfully!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
