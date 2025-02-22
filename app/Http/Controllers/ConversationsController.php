<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Repository\ConversationRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthManager;

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
        $this->middleware('auth');
        $this->r = $conversationRepository;
        $this->auth = $auth;
    }

    public function index () {
        return view('conversations/index', [
            'users' => $this->r->getConversations($this->auth->user()->id),
            'unread' => $this->r->unreadCount($this->auth->user()->id)
        ]);
    }

    public function show (User $user) {
        $me = $this->auth->user();
        $messages = $this->r->getMessagesFor($me->id, $user->id)->paginate(50);
        $unread = $this->r->unreadCount($me->id);
        if (isset($unread[$user->id])) {
            $this->r->readAllFrom($user->id, $me->id);
            unset($unread[$user->id]);
        }
        return view('conversations/show', [
            'users' => $this->r->getConversations($me->id),
            'user' => $user,
            'messages' => $messages,
            'unread' => $unread
        ]);
    }

    public function store (User $user, StoreMessageRequest $request) {
        $message = $this->r->createMessage(
                $request->get('content'),
                $this->auth->user()->id,
                $user->id
        );
        //$user->notify(new MessageReceived($message));
        return redirect()->route('conversations.show', [$user->id]);
    }

}
