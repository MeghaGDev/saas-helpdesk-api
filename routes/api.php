<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\TicketReplyController;
use App\Http\Controllers\Api\AdminTicketController;
use App\Http\Controllers\Api\AgentReplyController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);


    Route::post('/tickets', [TicketController::class, 'store']);
    Route::get('/my-tickets', [TicketController::class, 'myTickets']);

    Route::post('/tickets/{ticketId}/reply', [TicketReplyController::class, 'reply']);
    Route::get('/tickets/{ticketId}/conversation', [TicketReplyController::class, 'conversation']);

    Route::middleware('auth:sanctum')->post('/admin/tickets/{ticketId}/assign', [AdminTicketController::class,'assign']);

    Route::post('/agent/tickets/{id}/reply', [AgentReplyController::class, 'reply']);
});

Route::middleware('auth:sanctum')->get(
    '/tickets/{id}/conversation',
    [\App\Http\Controllers\Api\TicketConversationController::class, 'show']
);

Route::get('/ping', function () {
    return response()->json([
        'status' => true,
        'message' => 'Helpdesk API running'
    ]);
});

