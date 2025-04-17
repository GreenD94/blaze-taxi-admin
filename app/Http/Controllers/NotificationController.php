<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\NotificationDataTable;
use App\Models\Notification;
use App\Models\User;
use App\Notifications\CommonNotification;
use Throwable;
use OneSignal;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(NotificationDataTable $dataTable)
    {
        $pageTitle = __('message.list_form_title',['form' => __('message.notification')] );
        $auth_user = authSession();
        $assets = ['datatable'];
        $button = '';
        return $dataTable->render('global.datatable', compact('assets','pageTitle','button','auth_user'));
    }
    
    public function create()
    {
        $pageTitle = __('message.add_form_title',[ 'form' => __('message.notification')]);
        $assets = ['phone'];
        return view('notification.form', compact('pageTitle','assets'));
    }
    
    public function sendToUser(User $user, string $subject, string $message )
    {

        $notification_data = [
            'id' => $user->id,
            'type' => 'send_notification',
            'data' => [
                'rider_id' => $user->id,
                'rider_name' => optional($user)->display_name ?? '',
            ],
            'message' => $message,
            'subject' => $subject,
        ];

        try {
            $user->notify(new CommonNotification($notification_data['type'], $notification_data));
        } catch (Throwable $e) {
            report($e);
            throw $e;
        }

    }

    public function sendToUsers(array $usersId, array $content)
    {

        foreach ($usersId as $key) {
            $user = User::find($key);
            $this->sendToUser($user, $content['subject'], $content['message']);
        }

    }
    
    public function sendToAll(array $content)
    {

        OneSignal::sendNotificationToAll(
            $content['message'], 
            $url = null, 
            $data = null, 
            $buttons = null, 
            $schedule = null,
            $headings = $content['subject']
        );

    }
    
    public function sendToSegment(array $segment, array $content)
    {

        // $notification = [
        //     'headings' => [
        //         'en' => $content['message'],
        //     ],
        //     'contents' => [
        //         'en' => $content['subject'],
        //     ],
        // ];

        OneSignal::sendNotificationUsingTags(
            $content['message'],
            array(
                ["field" => "tag", "key" => "segment", "relation" => "=", "value" => $segment[0]]
            ),
            $url = null,
            $data = null,
            $buttons = null,
            $schedule = null,
            $headings = $content['subject']
        );

    }

    public function makeSend(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'message' => 'required',
            'target' => 'in:all,riders,drivers',
        ]);


        $target = $request->target;
        $notificationContent = [ 'message' => $request->message, 'subject' => $request->title ];

        // $users = User::whereNotIn('user_type', ['admin'])->where('status', 'active');

        if ($target=='all') {
            // $users = $users->where('user_type', $target);
            $this->sendToAll($notificationContent);
        } else {
            $this->sendToSegment([$target], $notificationContent);
        }

        // $users = $users->get();

        // $this->sendToUsers($users->pluck('id')->toArray(), ['message' => $request->message, 'subject' => $request->title]);

        return redirect()->route('notification.create')->withSuccess(__('message.notification_sent', ['form' => __('message.notification')]));

    }

    public function notificationList(Request $request)
    {
        $user = auth()->user();

        $user->last_notification_seen = now();
        $user->save();

        $type= $request->type;
        if($type == 'markas_read')
        {
            if(count($user->unreadNotifications) > 0 ) {
                $user->unreadNotifications->markAsRead();
            }
        }
        $notifications = $user->notifications->take(5);
        $all_unread_count = isset($user->unreadNotifications) ? $user->unreadNotifications->count() : 0;
        $response = [
            'status'     => true,
            'type'       => $type,
            'data'       => view('notification.list', compact('notifications', 'all_unread_count','user'))->render()
        ];

        return json_custom_response($response);
    }

    public function notificationCounts(Request $request)
    {
        $user = auth()->user();

        $unread_count = 0;
        $unread_total_count = 0;

        if(isset($user->unreadNotifications)){
            $unread_count = $user->unreadNotifications->where('created_at', '>', $user->last_notification_seen)->count() ;
            $unread_total_count = $user->unreadNotifications->count();
        }
        $response = [
            'status'            => true,
            'counts'            => $unread_count,
            'unread_total_count'=> $unread_total_count
        ];

        return json_custom_response($response);
    }
}