<?php

namespace App\Http\Controllers;

use App\Enums\TicketStatus;
use App\Models\Category;
use App\Models\KnowledgeArticle;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $ticketQuery = Ticket::query()->with(['creator', 'assignee', 'category']);

        if($user->isEmployee()) {
            $ticketQuery->where('user_id', $user->id);
        }elseif ($user->isTecnician()){
            $ticketQuery->where(function ($q) use ($user) {
                $q->where('assignee_to', $user->id)
                  ->orWhereNull('assignee_to');
            });
        }

        $allTickets = (clone $ticketQuery)->get();

        $stats = [
            'total' => $allTickets->count(),
            'open' => $allTickets->where('status', TicketStatus::Open)->count(),
            'in_progress' => $allTickets->where('status', TicketStatus::InProgress)->count(),
            'waiting' => $allTickets->where('status', TicketStatus::WaitingForUser)->count(),
            'resolved' => $allTickets->where('ststus', TicketStatus::Resolved)->count(),
            'closed' => $allTickets->where('status', TicketStatus::closed)->count(),
            'ai_assisted' => $allTickets->where('ai_summary')->count(),
        ];

        $recentTickets = (clone $ticketQuery)->latest()->take->(6)->get();

        $popularArticles = KnowledgeArticle::with('category')->where('is_published', true)->orderByDesc('views_count')->take(4)->get();
        
        $technicians = User::where('role', 'tecnician')->get();
        $categories = Category::withCount('tickets')->get();

        return view('dashboard.index', compact('stats', 'recentTickets', 'popularArticles', 'technicians', 'categories'));


    }
}
