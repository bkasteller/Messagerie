<?php

namespace App\Http\Controllers;

use App\Repository\ConversationRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationsController extends Controller
{

    /**
     * @var ConversationRepository
     */
    private $r;
    /**
     * @var AuthManager
     */
    private $auth;

    public function __construct(ConversationRepository $conversationRepository, AuthManager $auth)
    {
        $this->r = $conversationRepository;
        $this->auth = $auth;
    }

    public function index () {
        return view('conversations/index', [
            'users' => $this->r->getConversations($this->auth-user()->id)
        ]);
    }

    public function show (User $user) {
        return view('conversations/show', [
            'users' => $this->r->getConversations($this->auth-user()->id),
            'user' => $user
        ]);
    }

    public function store (User $user, Request $request) {

    }

}
