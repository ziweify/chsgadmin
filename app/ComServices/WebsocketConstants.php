<?php

namespace App\ComServices;

class WebsocketConstants
{
    //游戏聊天室相关
    public static string $chatListKeyPre = 'chatList';
    public static string $onlineKeyPre = "ws_online_";
    public static string $roomKeyPre = "ws_room_";
    public static string $roomFdKeyPre = "ws_room_fd_";
    public static int $onlineTimeout = 1800;
    public static string $CustomerChatListKeyPre = 'customerChatList';

    //事件常量
    public static string $NotReadMsgMemberPre = 'notReadMemberMsg';
    public static string $NotReadMsgAgentPre = 'notReadAgentMsg';
    public static string $NotReadApplyAgentPre = 'notReadAgentApply';
}