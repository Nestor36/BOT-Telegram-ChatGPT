<?php
# ________________________________________________________________________
#|  ___   ___         ___   ___   __    ___   ___      __    ___   ___ PHP|
#|   /   /__   /     /__   / _   /__)  /__/  / //     /__)  /  /    /     |
#|  /   /__   /__   /__   /__/  / (   /  /  / //     /__)  /__/    /      |
#|________________________________________________________________________|1.5.1

/*
TELEGRAM BOT PHP Library v1.5.1
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

TELEGRAM BOT is written in PHP, for faster deployment of a newly created
Telegram bot. It supports chat bot development by making development easier,
reducing complexity and making the code shorter.

Receive incoming HTTPS POST requests (contains bot update data) sent from
Telegram servers, and respond to these updates by interacting with Telegram Bot
API to make bot 'alive'. This library is for bot script that uses webhook to
receive bot updates.

Refer Telegram Bot ("https://core.telegram.org/bots") to know how to create a
Telegram bot.

Refer Telegram Bot API ("https://core.telegram.org/bots/api") for more
informations about available methods, available types and objects.

Telegram's Terms of Service: "https://telegram.org/tos"
Inappropiate usage might potentially get your account banned.
Use this library as your own risk.


Basic usage:
... load a reveived update:

    +-------------------------------------------------------------------+
    |                                                                   |
    |   // Include this library                                         |
    |   include("telegram-bot-1.5.1.php");                              |
    |                                                                   |
    |   $bot_token = "1103799654:AAGk_HkEI8Dz9QiBAtK3PQxQmWTJ7nt9Lts";  |
    |   $bot_username = "SampleBot";                                    |
    |                                                                   |
    |   // Create Bot object                                            |
    |   $bot = new Bot($bot_token, $bot_username);                      |
    |                                                                   |
    |   // Load update                                                  |
    |   $php_input = file_get_contents("php://input");                  |
    |   $update = $bot->load_update($php_input);                        |
    |                                                                   |
    +-------------------------------------------------------------------+

... or respond to a message:

    +-------------------------------------------------------------------+
    |                                                                   |
    |   // Respond "Hi!" when receive a message with content "Hello"    |
    |   if ($update->message) {                                         |
    |       if ($update->message->text == "Hello") {                    |
    |           $bot->send_message($update->message->chat->id, "Hi!");  |
    |       }                                                           |
    |   }                                                               |
    |                                                                   |
    +-------------------------------------------------------------------+


Copyright (c) 2021-2022 BotBox Studio. All rights reserved.
Version: 1.5.1.3
Last updated on 16/08/2022, 06:25:01 UTC
Author: Tan Ching Hung
GitHub: chinghung2000
Telegram: @chinghung2000
Email: tanchinghung5098.1@gmail.com
*/

/*
    List of classes available in this library:
        Bot
        Version
        Author
        Update
        User
        Chat
        Message
        MessageId
        MessageEntity
        PhotoSize
        Animation
        Audio
        Document
        Video
        VideoNote
        Voice
        Contact
        Dice
        PollOption
        PollAnswer
        Poll
        Location
        Venue
        ProximityAlertTriggered
        MessageAutoDeleteTimerChanged
        VoiceChatScheduled
        VoiceChatStarted
        VoiceChatEnded
        VoiceChatParticipantsInvited
        UserProfilePhotos
        File
        ReplyKeyboardMarkup
        KeyboardButton
        KeyboardButtonPollType
        ReplyKeyboardRemove
        InlineKeyboardMarkup
        InlineKeyboardButton
        LoginUrl
        CallbackQuery
        ForceReply
        ChatPhoto
        ChatInviteLink
        ChatAdministratorRights
        ChatMember
        ChatMemberUpdated
        ChatJoinRequest
        ChatPermissions
        ChatLocation
        BotCommand
        BotCommandScopeDefault
        BotCommandScopeAllPrivateChats
        BotCommandScopeAllGroupChats
        BotCommandScopeAllChatAdministrators
        BotCommandScopeChat
        BotCommandScopeChatAdministrators
        BotCommandScopeChatMember
        MenuButton
        MenuButtonCommands
        MenuButtonDefault
        ResponseParameters
        InputMediaPhoto
        InputMediaVideo
        InputMediaAnimation
        InputMediaAudio
        InputMediaDocument
        Sticker
        StickerSet
        MaskPosition
        InlineQuery
        InlineQueryResultArticle
        InlineQueryResultPhoto
        InlineQueryResultGif
        InlineQueryResultMpeg4Gif
        InlineQueryResultVideo
        InlineQueryResultAudio
        InlineQueryResultVoice
        InlineQueryResultDocument
        InlineQueryResultLocation
        InlineQueryResultVenue
        InlineQueryResultContact
        InlineQueryResultGame
        InlineQueryResultCachedMedia
        InlineQueryResultCachedSticker
        InputTextMessageContent
        InputLocationMessageContent
        InputVenueMessageContent
        InputContactMessageContent
        ChosenInlineResult
        Err

    << Note >>
        Some of the features are not provided in this library, there are:
        WebApp, Payments, Telegram Passport and Games. Some of the methods for
        Stickers are not provided.
*/

function map($array, $callable, ...$args) {
    $array_out = [];

    foreach ($array as $element) {
        array_push($array_out, $callable($element, ...$args));
    }

    return $array_out;
}

function classify($array, $class) {
    $array_out = [];

    foreach ($array as $element) {
        array_push($array_out, new $class($element));
    }

    return $array_out;
}

class Bot {
    /*
        This object represents a bot.

        List of methods available in Bot:
            request
            load_update
            get_self
            send_message
            send_photo
            send_audio
            send_document
            send_video
            send_animation
            send_voice
            send_video_note
            send_media_group
            send_sticker
            send_location
            send_venue
            send_contact
            send_poll
            stop_poll
            send_dice
            forward_message
            copy_message
            edit_message
            edit_caption
            edit_media
            edit_reply_markup
            delete_message
            send_chat_action
            get_profile_photos
            get_file
            get_file_url (deprecated)
            ban_member
            unban_member
            restrict_member
            promote_member
            set_custom_title
            ban_chat_sender_chat
            unban_chat_sender_chat
            set_chat_permissions
            renew_invite_link
            create_invite_link
            edit_invite_link
            revoke_invite_link
            approve_chat_join_request
            decline_chat_join_request
            set_chat_photo
            delete_chat_photo
            set_chat_title
            set_chat_description
            pin_message
            unpin_message
            unpin_all_messages
            leave_chat
            get_chat
            get_admins
            get_member_count
            get_member
            set_chat_sticker_set
            delete_chat_sticker_set
            answer_callback_query
            answer_inline_query
            set_commands
            delete_commands
            get_commands
            set_menu_button
            get_menu_button
            set_default_admin_rights
            get_default_admin_rights
    */

    private $TOKEN;
    private $URL;
    public $id;
    public $username;
    public $version;
    public $author;

    function __construct($bot_token, $bot_username) {
        $this->TOKEN = $bot_token;
        $this->URL = "https://api.telegram.org/bot" . $this->TOKEN . "/";
        $this->id = explode(":", $this->TOKEN)[0];
        $this->username = $bot_username;
        $this->version = new Version();
        $this->author = new Author();
    }

    private function request($url) {
        /*
            $url: `str`
        */

        $context = stream_context_create([
            'http' => [
                'ignore_errors' => true
            ]
        ]);
        $response = @file_get_contents($url, false, $context);
        return $response ? json_decode($response, true) : false;
    }

    public function load_update($update) {
        /*
            $update: `str`<Bot update JSON-object>
        */

        return new Update(json_decode($update, true));
    }

    public function get_self() {
        $url = $this->URL .
            "getMe";
        $r = $this->request($url);
        return $r ? ($r["ok"] ? new User($r["result"]) : new Err($r)) : false;
    }

    public function send_message($chat_id, $message, $parse_mode = "", $entities = [], $no_preview = false, $silent = false, $protected = false, $reply_to = "", $force_reply = true, $reply_markup = []) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $message: `str`
            $parse_mode: Optional[`str`[Markdown | MarkdownV2 | HTML]]
            $entities: Optional[`array`[*:method:`MessageEntity.create()`]]
            $no_preview: Optional[`bool`] Default: false
            $silent: Optional[`bool`] Default: false
            $protected: Optional[`bool`] Default: false
            $reply_to: Optional[`int`]
            $force_reply: Optional[`bool`] Default: false
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()` OR
                                            `ReplyKeyboardMarkup.create()` OR
                                            `ReplyKeyboardRemove.create()` OR
                                            `ForceReply.create()`]
        */

        $url = $this->URL .
            "sendMessage?chat_id=" . $chat_id .
            "&text=" . urlencode($message) .
            "&parse_mode=" . $parse_mode .
            "&disable_web_page_preview=" . $no_preview .
            "&disable_notification=" . $silent .
            "&protect_content=" . $protected .
            "&reply_to_message_id=" . $reply_to .
            "&allow_sending_without_reply=" . $force_reply;

        if ($entities) $url .= "&entities=" . json_encode($entities);
        if ($reply_markup) $url .= "&reply_markup=" . json_encode($reply_markup);
        $r = $this->request($url);
        return $r ? ($r["ok"] ? new Message($r["result"]) : new Err($r)) : false;
    }

    public function send_photo($chat_id, $photo, $caption = "", $parse_mode = "", $caption_entities = [], $silent = false, $protected = false, $reply_to = "", $force_reply = false, $reply_markup = []) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $photo: `str`[<file_id> | <File URL>]
            $caption: Optional[`str`] 0-1024 characters
            $parse_mode: Optional[`str`[Markdown | MarkdownV2 | HTML]]
            $caption_entities: Optional[`array`[*:method:`MessageEntity.create()`]]
            $silent: Optional[`bool`] Default: false
            $protected: Optional[`bool`] Default: false
            $reply_to: Optional[`int`]
            $force_reply: Optional[`bool`] Default: false
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()` OR
                                            `ReplyKeyboardMarkup.create()` OR
                                            `ReplyKeyboardRemove.create()` OR
                                            `ForceReply.create()`]
        */

        $url = $this->URL .
            "sendPhoto?chat_id=" . $chat_id .
            "&photo=" . urlencode($photo) .
            "&caption=" . urlencode($caption) .
            "&parse_mode=" . $parse_mode .
            "&disable_notification=" . $silent .
            "&protect_content=" . $protected .
            "&reply_to_message_id=" . $reply_to .
            "&allow_sending_without_reply=" . $force_reply;

        if ($caption_entities) $url .= "&caption_entities=" . json_encode($caption_entities);
        if ($reply_markup) $url .= "&reply_markup=" . json_encode($reply_markup);

        $r = $this->request($url);
        return $r ? ($r["ok"] ? new Message($r["result"]) : new Err($r)) : false;
    }

    public function send_audio($chat_id, $audio, $title = "", $performer = "", $duration = "", $thumb = "", $caption = "", $parse_mode = "", $caption_entities = [], $silent = false, $protected = false, $reply_to = "", $force_reply = false, $reply_markup = []) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $audio: `str`[<file_id> | <File URL>]
            $title: Optional[`str`]
            $performer: Optional[`str`]
            $duration: Optional[`int`]
            $thumb: Optional[`str`[<file_id> | <File URL>]]
            $caption: Optional[`str`] 0-1024 characters
            $parse_mode: Optional[`str`[Markdown | MarkdownV2 | HTML]]
            $caption_entities: Optional[`array`[*:method:`MessageEntity.create()`]]
            $silent: Optional[`bool`] Default: false
            $protected: Optional[`bool`] Default: false
            $reply_to: Optional[`int`]
            $force_reply: Optional[`bool`] Default: false
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()` OR
                                            `ReplyKeyboardMarkup.create()` OR
                                            `ReplyKeyboardRemove.create()` OR
                                            `ForceReply.create()`]
        */

        $url = $this->URL .
            "sendAudio?chat_id=" . $chat_id .
            "&audio=" . $audio .
            "&title=" . $title .
            "&performer=" . $performer .
            "&duration=" . $duration .
            "&thumb=" . $thumb .
            "&caption=" . urlencode($caption) .
            "&parse_mode=" . $parse_mode .
            "&disable_notification=" . $silent .
            "&protect_content=" . $protected .
            "&reply_to_message_id=" . $reply_to .
            "&allow_sending_without_reply=" . $force_reply;

        if ($caption_entities) $url .= "&caption_entities=" . json_encode($caption_entities);
        if ($reply_markup) $url .= "&reply_markup=" . json_encode($reply_markup);

        $r = $this->request($url);
        return $r ? ($r["ok"] ? new Message($r["result"]) : new Err($r)) : false;
    }

    public function send_document($chat_id, $document, $thumb = "", $ignore_type = false, $caption = "", $parse_mode = "", $caption_entities = [], $silent = false, $protected = false, $reply_to = "", $force_reply = false, $reply_markup = []) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $document: `str`[<file_id> | <File URL>]
            $thumb: Optional[`str`[<file_id> | <File URL>]]
            $ignore_type: Optional[`bool`] Default: false
            $caption: Optional[`str`] 0-1024 characters
            $parse_mode: Optional[`str`[Markdown | MarkdownV2 | HTML]]
            $caption_entities: Optional[`array`[*:method:`MessageEntity.create()`]]
            $silent: Optional[`bool`] Default: false
            $protected: Optional[`bool`] Default: false
            $reply_to: Optional[`int`]
            $force_reply: Optional[`bool`] Default: false
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()` OR
                                            `ReplyKeyboardMarkup.create()` OR
                                            `ReplyKeyboardRemove.create()` OR
                                            `ForceReply.create()`]
        */

        $url = $this->URL .
            "sendDocument?chat_id=" . $chat_id .
            "&document=" . $document .
            "&thumb=" . $thumb .
            "&disable_content_type_detection" . $ignore_type .
            "&caption=" . urlencode($caption) .
            "&parse_mode=" . $parse_mode .
            "&disable_notification=" . $silent .
            "&protect_content=" . $protected .
            "&reply_to_message_id=" . $reply_to .
            "&allow_sending_without_reply=" . $force_reply;

        if ($caption_entities) $url .= "&caption_entities=" . json_encode($caption_entities);
        if ($reply_markup) $url .= "&reply_markup=" . json_encode($reply_markup);

        $r = $this->request($url);
        return $r ? ($r["ok"] ? new Message($r["result"]) : new Err($r)) : false;
    }

    public function send_video($chat_id, $video, $duration = "", $width = "", $height = "", $supports_streaming = false, $thumb = "", $caption = "", $parse_mode = "", $caption_entities = [], $silent = false, $protected = false, $reply_to = "", $force_reply = false, $reply_markup = []) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $video: `str`[<file_id> | <File URL>]
            $duration: Optional[`int`]
            $width: Optional[`int`]
            $height: Optional[`int`]
            $supports_streaming: Optional[`bool`] Default: false
            $thumb: Optional[`str`[<file_id> | <File URL>]]
            $caption: Optional[`str`] 0-1024 characters
            $parse_mode: Optional[`str`[Markdown | MarkdownV2 | HTML]]
            $caption_entities: Optional[`array`[*:method:`MessageEntity.create()`]]
            $silent: Optional[`bool`] Default: false
            $protected: Optional[`bool`] Default: false
            $reply_to: Optional[`int`]
            $force_reply: Optional[`bool`] Default: false
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()` OR
                                            `ReplyKeyboardMarkup.create()` OR
                                            `ReplyKeyboardRemove.create()` OR
                                            `ForceReply.create()`]
        */

        $url = $this->URL .
            "sendVideo?chat_id=" . $chat_id .
            "&video=" . $video .
            "&duration=" . $duration .
            "&width=" . $width .
            "&height=" . $height .
            "&supports_streaming=" . $supports_streaming .
            "&thumb=" . $thumb .
            "&caption=" . urlencode($caption) .
            "&parse_mode=" . $parse_mode .
            "&disable_notification=" . $silent .
            "&protect_content=" . $protected .
            "&reply_to_message_id=" . $reply_to .
            "&allow_sending_without_reply=" . $force_reply;

        if ($caption_entities) $url .= "&caption_entities=" . json_encode($caption_entities);
        if ($reply_markup) $url .= "&reply_markup=" . json_encode($reply_markup);

        $r = $this->request($url);
        return $r ? ($r["ok"] ? new Message($r["result"]) : new Err($r)) : false;
    }

    public function send_animation($chat_id, $animation, $duration = "", $width = "", $height = "", $thumb = "", $caption = "", $parse_mode = "", $caption_entities = [], $silent = false, $protected = false, $reply_to = "", $force_reply = false, $reply_markup = []) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $animation: `str`[<file_id> | <File URL>]
            $duration: Optional[`int`]
            $width: Optional[`int`]
            $height: Optional[`int`]
            $thumb: Optional[`str`[<file_id> | <File URL>]]
            $caption: Optional[`str`] 0-1024 characters
            $parse_mode: Optional[`str`[Markdown | MarkdownV2 | HTML]]
            $caption_entities: Optional[`array`[*:method:`MessageEntity.create()`]]
            $silent: Optional[`bool`] Default: false
            $protected: Optional[`bool`] Default: false
            $reply_to: Optional[`int`]
            $force_reply: Optional[`bool`] Default: false
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()` OR
                                            `ReplyKeyboardMarkup.create()` OR
                                            `ReplyKeyboardRemove.create()` OR
                                            `ForceReply.create()`]
        */

        $url = $this->URL .
            "sendAnimation?chat_id=" . $chat_id .
            "&animation=" . $animation .
            "&duration=" . $duration .
            "&width=" . $width .
            "&height=" . $height .
            "&thumb=" . $thumb .
            "&caption=" . urlencode($caption) .
            "&parse_mode=" . $parse_mode .
            "&disable_notification=" . $silent .
            "&protect_content=" . $protected .
            "&reply_to_message_id=" . $reply_to .
            "&allow_sending_without_reply=" . $force_reply;

        if ($caption_entities) $url .= "&caption_entities=" . json_encode($caption_entities);
        if ($reply_markup) $url .= "&reply_markup=" . json_encode($reply_markup);

        $r = $this->request($url);
        return $r ? ($r["ok"] ? new Message($r["result"]) : new Err($r)) : false;
    }

    public function send_voice($chat_id, $voice, $duration = "", $caption = "", $parse_mode = "", $caption_entities = [], $silent = false, $protected = false, $reply_to = "", $force_reply = false, $reply_markup = []) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $voice: `str`[<file_id> | <File URL>]
            $duration: Optional[`int`]
            $caption: Optional[`str`] 0-1024 characters
            $parse_mode: Optional[`str`[Markdown | MarkdownV2 | HTML]]
            $caption_entities: Optional[`array`[*:method:`MessageEntity.create()`]]
            $silent: Optional[`bool`] Default: false
            $protected: Optional[`bool`] Default: false
            $reply_to: Optional[`int`]
            $force_reply: Optional[`bool`] Default: false
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()` OR
                                            `ReplyKeyboardMarkup.create()` OR
                                            `ReplyKeyboardRemove.create()` OR
                                            `ForceReply.create()`]
        */

        $url = $this->URL .
            "sendVoice?chat_id=" . $chat_id .
            "&voice=" . $voice .
            "&duration=" . $duration .
            "&caption=" . urlencode($caption) .
            "&parse_mode=" . $parse_mode .
            "&disable_notification=" . $silent .
            "&protect_content=" . $protected .
            "&reply_to_message_id=" . $reply_to .
            "&allow_sending_without_reply=" . $force_reply;

        if ($caption_entities) $url .= "&caption_entities=" . json_encode($caption_entities);
        if ($reply_markup) $url .= "&reply_markup=" . json_encode($reply_markup);

        $r = $this->request($url);
        return $r ? ($r["ok"] ? new Message($r["result"]) : new Err($r)) : false;
    }

    public function send_video_note($chat_id, $video_note, $duration = "", $length = "", $thumb = "", $silent = false, $protected = false, $reply_to = "", $force_reply = false, $reply_markup = []) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $video_note: `str`[<file_id> | <File URL>]
            $duration: Optional[`int`]
            $length: Optional[`int`]
            $thumb: Optional[`str`[<file_id> | <File URL>]]
            $silent: Optional[`bool`] Default: false
            $protected: Optional[`bool`] Default: false
            $reply_to: Optional[`int`]
            $force_reply: Optional[`bool`] Default: false
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()` OR
                                            `ReplyKeyboardMarkup.create()` OR
                                            `ReplyKeyboardRemove.create()` OR
                                            `ForceReply.create()`]
        */

        $url = $this->URL .
            "sendVideoNote?chat_id=" . $chat_id .
            "&video_note=" . $video_note .
            "&duration=" . $duration .
            "&length=" . $length .
            "&thumb=" . $thumb .
            "&disable_notification=" . $silent .
            "&protect_content=" . $protected .
            "&reply_to_message_id=" . $reply_to .
            "&allow_sending_without_reply=" . $force_reply;

        if ($reply_markup) $url .= "&reply_markup=" . json_encode($reply_markup);

        $r = $this->request($url);
        return $r ? ($r["ok"] ? new Message($r["result"]) : new Err($r)) : false;
    }

    public function send_media_group($chat_id, $media, $silent = false, $protected = false, $reply_to = "", $force_reply = false) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $media: `array`[*:method:`InputMediaAudio.create()` OR
                                     `InputMediaDocument.create()` OR
                                     `InputMediaPhoto.create()` OR
                                     `InputMediaVideo.create()`] Allowed items: 2 to 10
            $silent: Optional[`bool`] Default: false
            $protected: Optional[`bool`] Default: false
            $reply_to: Optional[`int`]
            $force_reply: Optional[`bool`] Default: false
        */

        $url = $this->URL .
            "sendMediaGroup?=chat_id" . $chat_id .
            "&media=" . json_encode($media) .
            "&disable_notification=" . $silent .
            "&protect_content=" . $protected .
            "&reply_to_message_id=" . $reply_to .
            "&allow_sending_without_reply=" . $force_reply;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? classify($r["result"], "Message") : new Err($r)) : false;
    }

    public function send_sticker($chat_id, $sticker, $silent = false, $protected = false, $reply_to = "", $force_reply = false, $reply_markup = []) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $sticker: `str`[<file_id> | <File URL>]
            $silent: Optional[`bool`] Default: false
            $protected: Optional[`bool`] Default: false
            $reply_to: Optional[`int`]
            $force_reply: Optional[`bool`] Default: false
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()` OR
                                            `ReplyKeyboardMarkup.create()` OR
                                            `ReplyKeyboardRemove.create()` OR
                                            `ForceReply.create()`]
        */

        $url = $this->URL .
            "sendSticker?chat_id=" . $chat_id .
            "&sticker=" . $sticker .
            "&disable_notification=" . $silent .
            "&protect_content=" . $protected .
            "&reply_to_message_id=" . $reply_to .
            "&allow_sending_without_reply=" . $force_reply;

        if ($reply_markup) $url .= "&reply_markup=" . json_encode($reply_markup);

        $r = $this->request($url);
        return $r ? ($r["ok"] ? new Message($r["result"]) : new Err($r)) : false;
    }

    public function send_location($chat_id, $latitude, $longitude, $horizontal_accuracy = "", $live_period = "", $direction = "", $proximity_alert_radius = "", $silent = false, $protected = false, $reply_to = "", $force_reply = false, $reply_markup = []) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $latitude: `float`
            $longitude: `float`
            $horizontal_accuracy: Optional[`float`] Range: 0 to 1500
            $live_period: Optional[`int`] Range: 60 to 86400
            $direction: Optional[`int`] Range: 1 to 360
            $proximity_alert_radius: Optional[`int`] Range: 1 to 100000
            $silent: Optional[`bool`] Default: false
            $protected: Optional[`bool`] Default: false
            $reply_to: Optional[`int`]
            $force_reply: Optional[`bool`] Default: false
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()` OR
                                            `ReplyKeyboardMarkup.create()` OR
                                            `ReplyKeyboardRemove.create()` OR
                                            `ForceReply.create()`]
        */

        $url = $this->URL .
            "sendLocation?chat_id=" . $chat_id .
            "&latitude=" . $latitude .
            "&longitude=" . $longitude .
            "&horizontal_accuracy=" . $horizontal_accuracy .
            "&live_period=" . $live_period .
            "&heading=" . $direction .
            "&proximity_alert_radius=" . $proximity_alert_radius .
            "&disable_notification=" . $silent .
            "&protect_content=" . $protected .
            "&reply_to_message_id=" . $reply_to .
            "&allow_sending_without_reply=" . $force_reply;

        if ($reply_markup) $url .= "&reply_markup=" . json_encode($reply_markup);

        $r = $this->request($url);
        return $r ? ($r["ok"] ? new Message($r["result"]) : new Err($r)) : false;
    }

    public function send_venue($chat_id, $latitude, $longitude, $name, $address, $foursquare_id = "", $foursquare_type = "", $google_place_id = "", $google_place_type = "", $silent = false, $protected = false, $reply_to = "", $force_reply = false, $reply_markup = []) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $latitude: `float`
            $longitude: `float`
            $name: `str`
            $address: `str`
            $foursquare_id: Optional[`str`]
            $foursquare_type: Optional[`str`]
            $google_place_id: Optional[`str`]
            $google_place_type: Optional[`str`]
            $silent: Optional[`bool`] Default: false
            $protected: Optional[`bool`] Default: false
            $reply_to: Optional[`int`]
            $force_reply: Optional[`bool`] Default: false
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()` OR
                                            `ReplyKeyboardMarkup.create()` OR
                                            `ReplyKeyboardRemove.create()` OR
                                            `ForceReply.create()`]
        */

        $url = $this->URL .
            "sendVenue?=chat_id" . $chat_id .
            "&latitude=" . $latitude .
            "&longitude=" . $longitude .
            "&title=" . $name .
            "&address=" . $address .
            "&foursquare_id=" . $foursquare_id .
            "&foursquare_type=" . $foursquare_type .
            "&google_place_id=" . $google_place_id .
            "&google_place_type=" . $google_place_type .
            "&disable_notification=" . $silent .
            "&protect_content=" . $protected .
            "&reply_to_message_id=" . $reply_to .
            "&allow_sending_without_reply=" . $force_reply;

        if ($reply_markup) $url .= "&reply_markup=" . json_encode($reply_markup);

        $r = $this->request($url);
        return $r ? ($r["ok"] ? new Message($r["result"]) : new Err($r)) : false;
    }

    public function send_contact($chat_id, $phone_number, $first_name, $last_name = "", $vcard = "", $silent = false, $protected = false, $reply_to = "", $force_reply = false, $reply_markup = []) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $phone_number: `str`
            $first_name: `str`
            $last_name: Optional[`str`]
            $vcard: Optional[`str`]
            $silent: Optional[`bool`] Default: false
            $protected: Optional[`bool`] Default: false
            $reply_to: Optional[`int`]
            $force_reply: Optional[`bool`] Default: false
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()` OR
                                            `ReplyKeyboardMarkup.create()` OR
                                            `ReplyKeyboardRemove.create()` OR
                                            `ForceReply.create()`]
        */

        $url = $this->URL .
            "sendContact?=chat_id" . $chat_id .
            "&phone_number=" . $phone_number .
            "&first_name=" . $first_name .
            "&last_name=" . $last_name .
            "&vcard=" . $vcard .
            "&disable_notification=" . $silent .
            "&protect_content=" . $protected .
            "&reply_to_message_id=" . $reply_to .
            "&allow_sending_without_reply=" . $force_reply;

        if ($reply_markup) $url .= "&reply_markup=" . json_encode($reply_markup);

        $r = $this->request($url);
        return $r ? ($r["ok"] ? new Message($r["result"]) : new Err($r)) : false;
    }

    public function send_poll($chat_id, $question, $options, $is_anonymous = true, $type = "regular", $multiple_answers = false, $correct_option_id = "", $explanation = "", $parse_mode = "", $explanation_entities = [], $open_period = "", $close_date = "", $is_closed = false, $silent = false, $protected = false, $reply_to = "", $force_reply = false, $reply_markup = []) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $question: `str` 1-300 characters
            $options:`array`[*`str`] 2-10 items, 1-100 characters each
            $is_anonymous: Optional[`bool`] Default: true
            $type: Optional[`str`[quiz | regular]] Default: regular
            $multiple_answers: Optional[`bool`] Default: false
            $correct_option_id: Optional[`int`]
            $explanation: Optional[`str`]
            $parse_mode: Optional[`str`[Markdown | MarkdownV2 | HTML]]
            $explanation_entities: Optional[`array`[*:method:`MessageEntity.create()`]]
            $open_period: Optional[`int`] Range: 5-600 (seconds). Can't be used together with $close_date
            $close_date: Optional[`int`] Can't be used together with $open_period
            $is_closed: Optional[`bool`] Default: false
            $silent: Optional[`bool`] Default: false
            $protected: Optional[`bool`] Default: false
            $reply_to: Optional[`int`]
            $force_reply: Optional[`bool`] Default: false
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()` OR
                                            `ReplyKeyboardMarkup.create()` OR
                                            `ReplyKeyboardRemove.create()` OR
                                            `ForceReply.create()`]
        */

        $url = $this->URL .
            "sendPoll?chat_id=" . $chat_id .
            "&question=" . $question .
            "&options=" . $options .
            "&is_anonymous=" . $is_anonymous .
            "&type=" . $type .
            "&allows_multiple_answers=" . $multiple_answers .
            "&correct_option_id=" . $correct_option_id .
            "&explanation=" . $explanation .
            "&explanation_parse_mode=" . $parse_mode .
            "&open_period=" . $open_period .
            "&close_date=" . $close_date .
            "&is_closed=" . $is_closed .
            "&disable_notification=" . $silent .
            "&protect_content=" . $protected .
            "&reply_to_message_id=" . $reply_to .
            "&allow_sending_without_reply=" . $force_reply;

        if ($explanation_entities) $url .= "&explanation_entities=" . json_encode($explanation_entities);
        if ($reply_markup) $url .= "&reply_markup=" . json_encode($reply_markup);

        $r = $this->request($url);
        return $r ? ($r["ok"] ? new Message($r["result"]) : new Err($r)) : false;
    }

    public function stop_poll($chat_id, $message_id, $reply_markup = []) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $message_id: `int`
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()`]
        */

        $url = $this->URL .
            "stopPoll?chat_id=" . $chat_id .
            "&message_id=" . $message_id;

        if ($reply_markup) $url .= "&reply_markup=" . json_encode($reply_markup);

        $r = $this->request($url);
        return $r ? ($r["ok"] ? new Poll($r["result"]) : new Err($r)) : false;
    }

    public function send_dice($chat_id, $emoji = "🎲", $silent = false, $protected = false, $reply_to = "", $force_reply = false, $reply_markup = []) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $emoji: Optional[`str`[🎲 | 🎯 | 🏀 | ⚽️ | 🎳 | 🎰]] Default: 🎲
            $silent: Optional[`bool`] Default: false
            $protected: Optional[`bool`] Default: false
            $reply_to: Optional[`int`]
            $send_without_reply: Optional[`bool`] Default: false
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()` OR
                                            `ReplyKeyboardMarkup.create()` OR
                                            `ReplyKeyboardRemove.create()` OR
                                            `ForceReply.create()`]
        */

        $url = $this->URL .
            "sendDice?chat_id=" . $chat_id .
            "&emoji=" . $emoji .
            "&disable_notification=" . $silent .
            "&protect_content=" . $protected .
            "&reply_to_message_id=" . $reply_to .
            "&allow_sending_without_reply=" . $force_reply;

        if ($reply_markup) $url .= "&reply_markup=" . json_encode($reply_markup);

        $r = $this->request($url);
        return $r ? ($r["ok"] ? new Message($r["result"]) : new Err($r)) : false;
    }

    public function forward_message($chat_id, $from_chat_id, $message_id, $silent = false, $protected = false) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $from_chat_id: `int` OR `str`<Channel username>
            $message_id: `int`
            $silent: Optional[`bool`] Default: false
            $protected: Optional[`bool`] Default: false
        */

        $url = $this->URL .
            "forwardMessage?chat_id=" . $chat_id .
            "&from_chat_id=" . $from_chat_id .
            "&message_id=" . $message_id .
            "&disable_notification=" . $silent .
            "&protect_content=" . $protected;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? new Message($r["result"]) : new Err($r)) : false;
    }

    public function copy_message($chat_id, $from_chat_id, $message_id, $caption = "", $parse_mode = "", $caption_entities = [], $silent = false, $protected = false, $reply_to = "", $force_reply = false, $reply_markup = []) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $from_chat_id: `int` OR `str`<Channel username>
            $message_id: `int`
            $caption: Optional[`str`] 0-1024 characters
            $parse_mode: Optional[`str`[Markdown | MarkdownV2 | HTML]]
            $caption_entities: Optional[`array`[*:method:`MessageEntity.create()`]]
            $silent: Optional[`bool`] Default: false
            $protected: Optional[`bool`] Default: false
            $reply_to: Optional[`int`]
            $force_reply: Optional[`bool`] Default: false
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()` OR
                                            `ReplyKeyboardMarkup.create()` OR
                                            `ReplyKeyboardRemove.create()` OR
                                            `ForceReply.create()`]
        */

        $url = $this->URL .
            "copyMessage?chat_id=" . $chat_id .
            "&from_chat_id=" . $from_chat_id .
            "&message_id=" . $message_id .
            "&caption=" . urlencode($caption) .
            "&parse_mode=" . $parse_mode .
            "&disable_notification=" . $silent .
            "&protect_content=" . $protected .
            "&reply_to_message_id=" . $reply_to .
            "&allow_sending_without_reply=" . $force_reply;

        if ($caption_entities) $url .= "&caption_entities=" . json_encode($caption_entities);
        if ($reply_markup) $url .= "&reply_markup=" . json_encode($reply_markup);

        $r = $this->request($url);
        return $r ? ($r["ok"] ? new MessageId($r["result"]) : new Err($r)) : false;
    }

    public function edit_message($message, $chat_id = "", $message_id = "", $inline_message_id = "", $parse_mode = "", $entities = [], $no_preview = false, $reply_markup = []) {
        /*
            $message: `str`
            $chat_id: Optional[`int` OR `str`<Channel username>] (use if $inline_message_id is not specified)
            $message_id: Optional[`int`] (use if $inline_message_id is not specified)
            $inline_message_id: Optional[`str`] (use if $chat_id and $message_id are not specified)
            $parse_mode: Optional[`str`[Markdown | MarkdownV2 | HTML]]
            $entities: Optional[`array`[*:method:`MessageEntity.create()`]]
            $no_preview: Optional[`bool`] Default: false
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()`]
        */

        $url = $this->URL .
            "editMessageText?chat_id=" . $chat_id .
            "&message_id=" . $message_id .
            "&inline_message_id=" . $inline_message_id .
            "&text=" . urlencode($message) .
            "&parse_mode=" . $parse_mode .
            "&disable_web_page_preview=" . $no_preview;

        if ($entities) $url .= "&entities=" . json_encode($entities);
        if ($reply_markup) $url .= "&reply_markup=" . json_encode($reply_markup);

        $r = $this->request($url);
        return $r ? ($r["ok"] ? ($inline_message_id ? $r["result"] : new Message($r["result"])) : new Err($r)) : false;
    }

    public function edit_caption($caption, $chat_id = "", $message_id = "", $inline_message_id = "", $parse_mode = "", $caption_entities = [], $reply_markup = []) {
        /*
            $caption: `str` 0-1024 characters
            $chat_id: Optional[`int` OR `str`<Channel username>] (use if $inline_message_id is not specified)
            $message_id: Optional[`int`] (use if $inline_message_id is not specified)
            $inline_message_id: Optional[`str`] (use if $chat_id and $message_id are not specified)
            $parse_mode: Optional[`str`[Markdown | MarkdownV2 | HTML]]
            $caption_entities: Optional[`array`[*:method:`MessageEntity.create()`]]
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()`]
        */

        $url = $this->URL .
            "editMessageCaption?chat_id=" . $chat_id .
            "&message_id=" . $message_id .
            "&inline_message_id=" . $inline_message_id .
            "&caption=" . urlencode($caption) .
            "&parse_mode=" . $parse_mode;

        if ($caption_entities) $url .= "&caption_entities=" . json_encode($caption_entities);
        if ($reply_markup) $url .= "&reply_markup=" . json_encode($reply_markup);

        $r = $this->request($url);
        return $r ? ($r["ok"] ? ($inline_message_id ? $r["result"] : new Message($r["result"])) : new Err($r)) : false;
    }

    public function edit_media($media, $chat_id = "", $message_id = "", $inline_message_id = "", $reply_markup = []) {
        /*
            $media: :method:`InputMediaAudio.create()` OR
                            `InputMediaDocument.create()` OR
                            `InputMediaPhoto.create()` OR
                            `InputMediaVideo.create()
            $chat_id: Optional[`int` OR `str`<Channel username>] (use if $inline_message_id is not specified)
            $message_id: Optional[`int`] (use if $inline_message_id is not specified)
            $inline_message_id: Optional[`str`] (use if $chat_id and $message_id are not specified)
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()`]
        */

        $url = $this->URL .
            "editMessageMedia?chat_id=" . $chat_id .
            "&message_id=" . $message_id .
            "&inline_message_id=" . $inline_message_id .
            "&media=" . json_encode($media);

        if ($reply_markup) $url .= "&reply_markup=" . json_encode($reply_markup);

        $r = $this->request($url);
        return $r ? ($r["ok"] ? ($inline_message_id ? $r["result"] : new Message($r["result"])) : new Err($r)) : false;
    }

    public function edit_reply_markup($chat_id = "", $message_id = "", $inline_message_id = "", $reply_markup = []) {
        /*
            $chat_id: Optional[`int` OR `str`<Channel username>] (use if $inline_message_id is not specified)
            $message_id: Optional[`int`] (use if $inline_message_id is not specified)
            $inline_message_id: Optional[`str`] (use if $chat_id and $message_id are not specified)
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()`]
        */

        $url = $this->URL .
            "editMessageReplyMarkup?chat_id=" . $chat_id .
            "&message_id=" . $message_id .
            "&inline_message_id=" . $inline_message_id;

        if ($reply_markup) $url .= "&reply_markup=" . json_encode($reply_markup);

        $r = $this->request($url);
        return $r ? ($r["ok"] ? ($inline_message_id ? $r["result"] : new Message($r["result"])) : new Err($r)) : false;
    }

    public function delete_message($chat_id, $message_id) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $message_id: `int`
        */

        $url = $this->URL .
            "deleteMessage?chat_id=" . $chat_id .
            "&message_id=" . $message_id;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function send_chat_action($chat_id, $action) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $action: `str`[typing | upload_photo | [record_video | upload_video] | [record_voice | upload_voice] | upload_document | choose_sticker | find_location | [record_video_note | upload_video_note ]]
        */

        $url = $this->URL .
            "sendChatAction?chat_id=" . $chat_id .
            "&action=" . $action;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function get_profile_photos($user_id, $offset = "", $limit = 100) {
        /*
            $user_id: `int`
            $offset: Optional[`int`]
            $limit: Optional[`int`] Range: 1-100, Default: 100
        */

        $url = $this->URL .
            "getUserProfilePhotos?user_id=" . $user_id .
            "&offset=" . $offset .
            "&limit=" . $limit;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? new UserProfilePhotos($r["result"]) : new Err($r)) : false;
    }

    public function get_file($file_id) {
        /*
            $file_id: `str`
        */

        $url = $this->URL .
            "getFile?file_id=" . $file_id;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? new File($r["result"]) : new Err($r)) : false;
    }

    public function get_file_url($file_path) {
        /*
            $file_path: `str`
        */

        return "https://api.telegram.org/file/bot" . $this->TOKEN . "/" . $file_path;
    }

    public function ban_member($chat_id, $user_id, $until_date = "", $revoke_messages = false) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $user_id: `int`
            $until_date: Optional[`int`<UNIX time>] Note: less than 30s or more than 366d are considered to be banned forever.
            $revoke_messages: Optional[`bool`] Default: false
        */

        $url = $this->URL .
            "banChatMember?chat_id=" . $chat_id .
            "&user_id=" . $user_id .
            "&until_date=" . $until_date .
            "&revoke_messages=" . $revoke_messages;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function unban_member($chat_id, $user_id, $only_banned = false) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $user_id: `int`
            $only_banned: Optional[`bool`] Default: false
        */

        $url = $this->URL .
            "unbanChatMember?chat_id=" . $chat_id .
            "&user_id=" . $user_id .
            "&only_if_banned=" . $only_banned;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function restrict_member($chat_id, $user_id, $permissions, $until_date = "") {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $user_id: `int`
            $permissions: :method:`ChatPermissions.create()`
            $until_date: Optional[`int`<UNIX time>] Note: less than 30s or more than 366d are considered to be banned forever
        */

        $url = $this->URL .
            "restrictChatMember?chat_id=" . $chat_id .
            "&user_id=" . $user_id .
            "&permissions=" . json_encode($permissions) .
            "&until_date=" . $until_date;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function promote_member($chat_id, $user_id, $is_anonymous = false, $can_manage_chat = false, $can_post_messages = false, $can_edit_messages = false, $can_delete_messages = false, $can_manage_video_chats = false, $can_restrict_members = false, $can_promote_members = false, $can_change_info = false, $can_invite_users = false, $can_pin_messages = false) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $user_id: `int`
            $is_anonymous: Optional[`bool`] Default: false
            $can_manage_chat: Optional[`bool`] Default: false
            $can_post_messages: Optional[`bool`] Default: false
            $can_edit_messages: Optional[`bool`] Default: false
            $can_delete_messages: Optional[`bool`] Default: false
            $can_manage_video_chats: Optional[`bool`] Default: false
            $can_restrict_members: Optional[`bool`] Default: false
            $can_promote_members: Optional[`bool`] Default: false
            $can_change_info: Optional[`bool`] Default: false
            $can_invite_users: Optional[`bool`] Default: false
            $can_pin_messages: Optional[`bool`] Default: false
        */

        $url = $this->URL .
            "promoteChatMember?chat_id=" . $chat_id .
            "&user_id=" . $user_id .
            "&is_anonymous=" . $is_anonymous .
            "&can_manage_chat=" . $can_manage_chat .
            "&can_post_messages=" . $can_post_messages .
            "&can_edit_messages=" . $can_edit_messages .
            "&can_delete_messages=" . $can_delete_messages .
            "&can_manage_video_chats=" . $can_manage_video_chats .
            "&can_restrict_members=" . $can_restrict_members .
            "&can_promote_members=" . $can_promote_members .
            "&can_change_info=" . $can_change_info .
            "&can_invite_users=" . $can_invite_users .
            "&can_pin_messages=" . $can_pin_messages;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function set_custom_title($chat_id, $user_id, $custom_title) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $user_id: `int`
            $custom_title: `str` 0-16 characters, emoji are not allowed
        */

        $url = $this->URL .
            "setChatAdministratorCustomTitle?chat_id=" . $chat_id .
            "&user_id=" . $user_id .
            "&custom_title=" . $custom_title;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function ban_chat_sender_chat($chat_id, $sender_chat_id) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $sender_chat_id: `int`
        */

        $url = $this->URL .
            "banChatSenderChat?chat_id=" . $chat_id .
            "&sender_chat_id=" . $sender_chat_id;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function unban_chat_sender_chat($chat_id, $sender_chat_id) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $sender_chat_id: `int`
        */

        $url = $this->URL .
            "unbanChatSenderChat?chat_id=" . $chat_id .
            "&sender_chat_id=" . $sender_chat_id;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function set_chat_permissions($chat_id, $permissions) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $permissions: :method:`ChatPermissions.create()`
        */

        $url = $this->URL .
            "setChatPermissions?chat_id=" . $chat_id .
            "&permissions=" . json_encode($permissions);

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function renew_invite_link($chat_id) {
        /*
            $chat_id: `int` OR `str`<Channel username>
        */

        $url = $this->URL .
            "exportChatInviteLink?chat_id=" . $chat_id;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function create_invite_link($chat_id, $name = "", $expire_date = "", $member_limit = "", $require_approval = false) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $name: Optional[`str`]
            $expire_date: Optional[`int`<UNIX time>]
            $member_limit: Optional[`int`] Range: 1-99999, can't be specified when $require_approval is true
            $require_approval: Optional[`bool`] Default: false
        */

        $url = $this->URL .
            "createChatInviteLink?chat_id=" . $chat_id .
            "&name=" . $name .
            "&expire_date=" . $expire_date .
            "&member_limit=" . $member_limit .
            "&creates_join_request=" . $require_approval;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? new ChatInviteLink($r["result"]) : new Err($r)) : false;
    }

    public function edit_invite_link($chat_id, $invite_link, $name = "", $expire_date = "", $member_limit = "", $require_approval = false) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $name: Optional[`str`]
            $invite_link: `str`
            $expire_date: Optional[`int`<UNIX time>]
            $member_limit: Optional[`int`] Range: 1-99999, can't be specified when $require_approval is true
            $require_approval: Optional[`bool`] Default: false
        */

        $url = $this->URL .
            "editChatInviteLink?chat_id=" . $chat_id .
            "&invite_link=" . $invite_link .
            "&name=" . $name .
            "&expire_date=" . $expire_date .
            "&member_limit=" . $member_limit .
            "&creates_join_request=" . $require_approval;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? new ChatInviteLink($r["result"]) : new Err($r)) : false;
    }

    public function revoke_invite_link($chat_id, $invite_link) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $invite_link: `str`
        */

        $url = $this->URL .
            "revokeChatInviteLink?chat_id=" . $chat_id .
            "&invite_link=" . $invite_link;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? new ChatInviteLink($r["result"]) : new Err($r)) : false;
    }

    public function approve_chat_join_request($chat_id, $user_id) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $user_id: `int`
        */

        $url = $this->URL .
            "approveChatJoinRequest?chat_id=" . $chat_id .
            "&user_id=" . $user_id;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function decline_chat_join_request($chat_id, $user_id) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $user_id: `int`
        */

        $url = $this->URL .
            "declineChatJoinRequest?chat_id=" . $chat_id .
            "&user_id=" . $user_id;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function set_chat_photo($chat_id, $photo) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $photo: `str`[<file_id> | <File URL>]
        */

        $url = $this->URL .
            "setChatPhoto?chat_id=" . $chat_id .
            "&photo=" . $photo;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function delete_chat_photo($chat_id) {
        /*
            $chat_id: `int` OR `str`<Channel username>
        */

        $url = $this->URL .
            "deleteChatPhoto?chat_id=" . $chat_id;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function set_chat_title($chat_id, $title) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $title: `str` 1-255 characters
        */

        $url = $this->URL .
            "setChatTitle?chat_id=" . $chat_id .
            "&title=" . $title;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function set_chat_description($chat_id, $description = "") {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $description: Optional[`str`] 0-255 characters
        */

        $url = $this->URL .
            "setChatDescription?chat_id=" . $chat_id .
            "&description=" . $description;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function pin_message($chat_id, $message_id, $silent = false) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $message_id: `int`
            $silent: Optional[`bool`] Default: false
        */

        $url = $this->URL .
            "pinChatMessage?chat_id=" . $chat_id .
            "&message_id=" . $message_id .
            "&disable_notification=" . $silent;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function unpin_message($chat_id, $message_id) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $message_id: `int`
        */

        $url = $this->URL .
            "unpinChatMessage?chat_id=" . $chat_id .
            "&message_id=" . $message_id;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function unpin_all_messages($chat_id) {
        /*
            $chat_id: `int` OR `str`<Channel username>
        */

        $url = $this->URL .
            "unpinAllChatMessages?chat_id=" . $chat_id;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function leave_chat($chat_id) {
        /*
            $chat_id: `int` OR `str`<Channel username>
        */

        $url = $this->URL .
            "leaveChat?chat_id=" . $chat_id;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function get_chat($chat_id) {
        /*
            $chat_id: `int` OR `str`<Channel username>
        */

        $url = $this->URL .
            "getChat?chat_id=" . $chat_id;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? new Chat($r["result"]) : new Err($r)) : false;
    }

    public function get_admins($chat_id) {
        /*
            $chat_id: `int` OR `str`<Channel username>
        */

        $url = $this->URL .
            "getChatAdministrators?chat_id=" . $chat_id;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? classify($r["result"], "ChatMember") : new Err($r)) : false;
    }

    public function get_member_count($chat_id) {
        /*
            $chat_id: `int` OR `str`<Channel username>
        */

        $url = $this->URL .
            "getChatMemberCount?chat_id=" . $chat_id;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function get_member($chat_id, $user_id) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $user_id: `int`
        */

        $url = $this->URL .
            "getChatMember?chat_id=" . $chat_id .
            "&user_id=" . $user_id;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? new ChatMember($r["result"]) : new Err($r)) : false;
    }

    public function set_chat_sticker_set($chat_id, $sticker_set_name) {
        /*
            $chat_id: `int` OR `str`<Channel username>
            $sticker_set_name: `str`
        */

        $url = $this->URL .
            "setChatStickerSet?chat_id=" . $chat_id .
            "&sticker_set_name=" . $sticker_set_name;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function delete_chat_sticker_set($chat_id) {
        /*
            $chat_id: `int` OR `str`<Channel username>
        */

        $url = $this->URL .
            "deleteChatStickerSet?chat_id=" . $chat_id;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function answer_callback_query($callback_query_id, $text = "", $show_alert = false, $url = "", $cache_time = 0) {
        /*
            $callback_query_id: `str`
            $text: Optional[`str`] 0-200 characters
            $show_alert: Optional[`bool`] Default: false
            $url: Optional[`str`]
            $cache_time: Optional[`int`] Default: 0
        */

        $url = $this->URL .
            "answerCallbackQuery?callback_query_id=" . $callback_query_id .
            "&text=" . $text .
            "&show_alert=" . $show_alert .
            "&url=" . $url .
            "&cache_time=" . $cache_time;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function set_commands($commands, $scope = [], $language_code = "") {
        /*
            $commands: `array`[*:method:`BotCommand.create()`]
            $scope: Optional[:method:`BotCommandScopeDefault.create()` OR
                                     `BotCommandScopeAllPrivateChats.create()` OR
                                     `BotCommandScopeAllGroupChats.create()` OR
                                     `BotCommandScopeAllChatAdministrators.create()` OR
                                     `BotCommandScopeChat.create()` OR
                                     `BotCommandScopeChatAdministrators.create()` OR
                                     `BotCommandScopeChatMember.create()`]
            $language_code: Optional[`str`]
        */

        $url = $this->URL .
            "setMyCommands?commands=" . json_encode($commands) .
            "&language_code=" . $language_code;

        if ($scope) $url .= "&scope=" . json_encode($scope);

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function delete_commands($scope = [], $language_code = "") {
        /*
            $scope: Optional[:method:`BotCommandScopeDefault.create()` OR
                                     `BotCommandScopeAllPrivateChats.create()` OR
                                     `BotCommandScopeAllGroupChats.create()` OR
                                     `BotCommandScopeAllChatAdministrators.create()` OR
                                     `BotCommandScopeChat.create()` OR
                                     `BotCommandScopeChatAdministrators.create()` OR
                                     `BotCommandScopeChatMember.create()`]
            $language_code: Optional[`str`]
        */

        $url = $this->URL .
            "deleteMyCommands?language_code=" . $language_code;

        if ($scope) $url .= "&scope=" . json_encode($scope);

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function get_commands($scope = [], $language_code = "") {
        /*
            $scope: Optional[:method:`BotCommandScopeDefault.create()` OR
                                     `BotCommandScopeAllPrivateChats.create()` OR
                                     `BotCommandScopeAllGroupChats.create()` OR
                                     `BotCommandScopeAllChatAdministrators.create()` OR
                                     `BotCommandScopeChat.create()` OR
                                     `BotCommandScopeChatAdministrators.create()` OR
                                     `BotCommandScopeChatMember.create()`]
            $language_code: Optional[`str`]
        */

        $url = $this->URL .
            "getMyCommands?language_code=" . $language_code;

        if ($scope) $url .= "&scope=" . json_encode($scope);

        $r = $this->request($url);
        return $r ? ($r["ok"] ? classify($r["result"], "BotCommand") : new Err($r)) : false;
    }

    public function set_menu_button($chat_id = "", $menu_button = "") {
        /*
            $chat_id: Optional[`int`]
            $menu_button: Optional[:method:`MenuButton.create()`]
        */

        $url = $this->URL .
            "setChatMenuButton?chat_id=" . $chat_id .
            "&menu_button=" . json_encode($menu_button);

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function get_menu_button($chat_id = "") {
        /*
            $chat_id: Optional[`int`]
        */

        $url = $this->URL .
            "getChatMenuButton?chat_id=" . $chat_id;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? new MenuButton($r["result"]) : new Err($r)) : false;
    }

    public function set_default_admin_rights($rights = "", $for_channels = false) {
        /*
            $rights: Optional[:method:`ChatAdministratorRights.create()`]
            $for_channels: Optional[`bool`] Default: false
        */

        $url = $this->URL .
            "setMyDefaultAdministratorRights?rights=" . json_encode($rights) .
            "&for_channels=" . $for_channels;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }

    public function get_default_admin_rights($for_channels = false) {
        /*
            $for_channels: Optional[`bool`] Default: false
        */

        $url = $this->URL .
            "getMyDefaultAdministratorRights?for_channels=" . $for_channels;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? new ChatAdministratorRights($r["result"]) : new Err($r)) : false;
    }

    public function answer_inline_query($inline_query_id, $results, $cache_time = 300, $is_personal = false, $next_offset = "", $switch_pm_text = "", $switch_pm_parameter = "") {
        /*
            $inline_query_id: `str`
            $results: `array`[*:method:`InlineQueryResult.create()`]
            $cache_time: Optional[`int`] Default: 300
            $is_personal: Optional[`bool`] Default: false
            $next_offset: Optional[`str`]
            $switch_pm_text: Optional[`str`]
            $switch_pm_parameter: Optional[`str`]
        */

        $url = $this->URL .
            "answerInlineQuery?inline_query_id=" . $inline_query_id .
            "&results=" . json_encode($results) .
            "&cache_time=" . $cache_time .
            "&is_personal=" . $is_personal .
            "&next_offset=" . $next_offset .
            "&switch_pm_text=" . $switch_pm_text .
            "&switch_pm_parameter=" . $switch_pm_parameter;

        $r = $this->request($url);
        return $r ? ($r["ok"] ? $r["result"] : new Err($r)) : false;
    }
}

class Version {
    /*
        This object represents a version information of a bot.
    */

    public $name;
    public $ver;
    public $timestamp;
    public $date;
    public $time;
}

class Author {
    /*
        This object represents bot author's information.
    */

    public $id;
    public $username;
    public $name;
}

class Update {
    /*
        This object represents an incoming update.
    */

    public $id;
    public $message;
    public $edited_message;
    public $channel_post;
    public $edited_channel_post;
    public $inline_query;
    public $chosen_inline_result;
    public $callback_query;
    public $poll;
    public $poll_answer;
    public $my_chat_member;
    public $chat_member;
    public $chat_join_request;

    function __construct($update) {
        if (is_array($update)) {
            $this->id = $update["update_id"];
            $this->message = array_key_exists("message", $update) ? new Message($update["message"]) : null;
            $this->edited_message = array_key_exists("edited_message", $update) ? new Message($update["edited_message"]) : null;
            $this->channel_post = array_key_exists("channel_post", $update) ? new Message($update["channel_post"]) : null;
            $this->edited_channel_post = array_key_exists("edited_channel_post", $update) ? new Message($update["edited_channel_post"]) : null;
            $this->inline_query = array_key_exists("inline_query", $update) ? new InlineQuery($update["inline_query"]) : null;
            $this->chosen_inline_result = array_key_exists("chosen_inline_result", $update) ? new ChosenInlineResult($update["chosen_inline_result"]) : null;
            $this->callback_query = array_key_exists("callback_query", $update) ? new CallbackQuery($update["callback_query"]) : null;
            $this->poll = array_key_exists("poll", $update) ? new Poll($update["poll"]) : null;
            $this->poll_answer = array_key_exists("poll_answer", $update) ? new PollAnswer($update["poll_answer"]) : null;
            $this->my_chat_member = array_key_exists("my_chat_member", $update) ? new ChatMemberUpdated($update["my_chat_member"]) : null;
            $this->chat_member = array_key_exists("chat_member", $update) ? new ChatMemberUpdated($update["chat_member"]) : null;
            $this->chat_join_request = array_key_exists("chat_join_request", $update) ? new ChatJoinRequest($update["chat_join_request"]) : null;
        }
    }
}

class User {
    /*
        This object represents a Telegram user or bot.
    */

    public $id;
    public $is_bot;
    public $first_name;
    public $last_name;
    public $username;
    public $language_code;
    public $is_premium;
    public $added_to_attachment_menu;
    public $can_join_groups;
    public $can_read_all_group_messages;
    public $supports_inline_queries;

    function __construct($user) {
        $this->id = $user["id"];
        $this->is_bot = $user["is_bot"];
        $this->first_name = $user["first_name"];
        $this->last_name = array_key_exists("last_name", $user) ? $user["last_name"] : null;
        $this->username = array_key_exists("username", $user) ? $user["username"] : null;
        $this->language_code = array_key_exists("language_code", $user) ? $user["language_code"] : null;
        $this->is_premium = array_key_exists("is_premium", $user) ? $user["is_premium"] : null;
        $this->added_to_attachment_menu = array_key_exists("added_to_attachment_menu", $user) ? $user["added_to_attachment_menu"] : null;
        $this->can_join_groups = array_key_exists("can_join_groups", $user) ? $user["can_join_groups"] : null;
        $this->can_read_all_group_messages = array_key_exists("can_read_all_group_messages", $user) ? $user["can_read_all_group_messages"] : null;
        $this->supports_inline_queries = array_key_exists("supports_inline_queries", $user) ? $user["supports_inline_queries"] : null;
    }
}

class Chat {
    /*
        This object represents a chat.
    */

    public $id;
    public $type;
    public $title;
    public $username;
    public $first_name;
    public $last_name;
    public $photo;
    public $bio;
    public $has_private_forwards;
    public $join_to_send_messages;
    public $join_by_request;
    public $description;
    public $invite_link;
    public $pinned_message;
    public $permissions;
    public $slow_mode_delay;
    public $message_auto_delete_time;
    public $has_protected_content;
    public $sticker_set_name;
    public $can_set_sticker_set;
    public $linked_chat_id;
    public $location;

    function __construct($chat) {
        $this->id = $chat["id"];
        $this->type = $chat["type"];
        $this->title = array_key_exists("title", $chat) ? $chat["title"] : null;
        $this->username = array_key_exists("username", $chat) ? $chat["username"] : null;
        $this->first_name = array_key_exists("first_name", $chat) ? $chat["first_name"] : null;
        $this->last_name = array_key_exists("last_name", $chat) ? $chat["last_name"] : null;
        $this->photo = array_key_exists("photo", $chat) ? new ChatPhoto($chat["photo"]) : null;
        $this->bio = array_key_exists("bio", $chat) ? $chat["bio"] : null;
        $this->has_private_forwards = array_key_exists("has_private_forwards", $chat) ? $chat["has_private_forwards"] : null;
        $this->join_to_send_messages = array_key_exists("join_to_send_messages", $chat) ? $chat["join_to_send_messages"] : null;
        $this->join_by_request = array_key_exists("join_by_request", $chat) ? $chat["join_by_request"] : null;
        $this->description = array_key_exists("description", $chat) ? $chat["description"] : null;
        $this->invite_link = array_key_exists("invite_link", $chat) ? $chat["invite_link"] : null;
        $this->pinned_message = array_key_exists("pinned_message", $chat) ? new Message($chat["pinned_message"]) : null;
        $this->permissions = array_key_exists("permissions", $chat) ? new ChatPermissions($chat["permissions"]) : null;
        $this->slow_mode_delay = array_key_exists("slow_mode_delay", $chat) ? $chat["slow_mode_delay"] : null;
        $this->message_auto_delete_time = array_key_exists("message_auto_delete_time", $chat) ? $chat["message_auto_delete_time"] : null;
        $this->has_protected_content = array_key_exists("has_protected_content", $chat) ? $chat["has_protected_content"] : null;
        $this->sticker_set_name = array_key_exists("sticker_set_name", $chat) ? $chat["sticker_set_name"] : null;
        $this->can_set_sticker_set = array_key_exists("can_set_sticker_set", $chat) ? $chat["can_set_sticker_set"] : null;
        $this->linked_chat_id = array_key_exists("linked_chat_id", $chat) ? $chat["linked_chat_id"] : null;
        $this->location = array_key_exists("location", $chat) ? new ChatLocation($chat["location"]) : null;
    }
}

class Message {
    /*
        This object represents a message.
    */

    public $id;
    public $from;
    public $sender_chat;
    public $date;
    public $chat;
    public $forward_from;
    public $forward_from_chat;
    public $forward_from_message_id;
    public $forward_signature;
    public $forward_sender_name;
    public $forward_date;
    public $is_automatic_forward;
    public $reply_to_message;
    public $via_bot;
    public $edit_date;
    public $has_protected_content;
    public $media_group_id;
    public $author_signature;
    public $text;
    public $entities;
    public $animation;
    public $audio;
    public $document;
    public $photo;
    public $sticker;
    public $video;
    public $video_note;
    public $voice;
    public $caption;
    public $caption_entities;
    public $contact;
    public $dice;
    public $poll;
    public $venue;
    public $location;
    public $new_chat_members;
    public $left_chat_member;
    public $new_chat_title;
    public $new_chat_photo;
    public $delete_chat_photo;
    public $group_chat_created;
    public $supergroup_chat_created;
    public $channel_chat_created;
    public $message_auto_delete_timer_changed;
    public $migrate_to_chat_id;
    public $migrate_from_chat_id;
    public $pinned_message;
    public $connected_website;
    public $proximity_alert_triggered;
    public $voice_chat_scheduled;
    public $voice_chat_started;
    public $voice_chat_ended;
    public $voice_chat_participants_invited;
    public $reply_markup;

    function __construct($message) {
        $this->id = $message["message_id"];
        $this->from = array_key_exists("from", $message) ? new User($message["from"]) : null;
        $this->sender_chat = array_key_exists("sender_chat", $message) ? new Chat($message["sender_chat"]) : null;
        $this->date = $message["date"];
        $this->chat = new Chat($message["chat"]);
        $this->forward_from = array_key_exists("forward_from", $message) ? new User($message["forward_from"]) : null;
        $this->forward_from_chat = array_key_exists("forward_from_chat", $message) ? new Chat($message["forward_from_chat"]) : null;
        $this->forward_from_message_id = array_key_exists("forward_from_message_id", $message) ? $message["forward_from_message_id"] : null;
        $this->forward_signature = array_key_exists("forward_signature", $message) ? $message["forward_signature"] : null;
        $this->forward_sender_name = array_key_exists("forward_sender_name", $message) ? $message["forward_sender_name"] : null;
        $this->forward_date = array_key_exists("forward_date", $message) ? $message["forward_date"] : null;
        $this->is_automatic_forward = array_key_exists("is_automatic_forward", $message) ? $message["is_automatic_forward"] : null;
        $this->reply_to_message = array_key_exists("reply_to_message", $message) ? new Message($message["reply_to_message"]) : null;
        $this->via_bot = array_key_exists("via_bot", $message) ? new User($message["via_bot"]) : null;
        $this->edit_date = array_key_exists("edit_date", $message) ? $message["edit_date"] : null;
        $this->has_protected_content = array_key_exists("has_protected_content", $message) ? $message["has_protected_content"] : null;
        $this->media_group_id = array_key_exists("media_group_id", $message) ? $message["media_group_id"] : null;
        $this->author_signature = array_key_exists("author_signature", $message) ? $message["author_signature"] : null;
        $this->text = array_key_exists("text", $message) ? $message["text"] : null;
        $this->entities = array_key_exists("entities", $message) ? classify($message["entities"], "MessageEntity") : null;
        $this->animation = array_key_exists("animation", $message) ? new Animation($message["animation"]) : null;
        $this->audio = array_key_exists("audio", $message) ? new Audio($message["audio"]) : null;
        $this->document = array_key_exists("document", $message) ? new Document($message["document"]) : null;
        $this->photo = array_key_exists("photo", $message) ? classify($message["photo"], "PhotoSize") : null;
        $this->sticker = array_key_exists("sticker", $message) ? new Sticker($message["sticker"]) : null;
        $this->video = array_key_exists("video", $message) ? new Video($message["video"]) : null;
        $this->video_note = array_key_exists("video_note", $message) ? new VideoNote($message["video_note"]) : null;
        $this->voice = array_key_exists("voice", $message) ? new Voice($message["voice"]) : null;
        $this->caption = array_key_exists("caption", $message) ? $message["caption"] : null;
        $this->caption_entities = array_key_exists("caption_entities", $message) ? classify($message["caption_entities"], "MessageEntity") : null;
        $this->contact = array_key_exists("contact", $message) ? new Contact($message["contact"]) : null;
        $this->dice = array_key_exists("dice", $message) ? new Dice($message["dice"]) : null;
        $this->poll = array_key_exists("poll", $message) ? new Poll($message["poll"]) : null;
        $this->venue = array_key_exists("venue", $message) ? new Venue($message["venue"]) : null;
        $this->location = array_key_exists("location", $message) ? new Location($message["location"]) : null;
        $this->new_chat_members = array_key_exists("new_chat_members", $message) ? classify($message["new_chat_members"], "User") : null;
        $this->left_chat_member = array_key_exists("left_chat_member", $message) ? new User($message["left_chat_member"]) : null;
        $this->new_chat_title = array_key_exists("new_chat_title", $message) ? $message["new_chat_title"] : null;
        $this->new_chat_photo = array_key_exists("new_chat_photo", $message) ? classify($message["new_chat_photo"], "PhotoSize") : null;
        $this->delete_chat_photo = array_key_exists("delete_chat_photo", $message) ? $message["delete_chat_photo"] : null;
        $this->group_chat_created = array_key_exists("group_chat_created", $message) ? $message["group_chat_created"] : null;
        $this->supergroup_chat_created = array_key_exists("supergroup_chat_created", $message) ? $message["supergroup_chat_created"] : null;
        $this->channel_chat_created = array_key_exists("channel_chat_created", $message) ? $message["channel_chat_created"] : null;
        $this->message_auto_delete_timer_changed = array_key_exists("message_auto_delete_timer_changed", $message) ? new MessageAutoDeleteTimerChanged($message["message_auto_delete_timer_changed"]) : null;
        $this->migrate_to_chat_id = array_key_exists("migrate_to_chat_id", $message) ? $message["migrate_to_chat_id"] : null;
        $this->migrate_from_chat_id = array_key_exists("migrate_from_chat_id", $message) ? $message["migrate_from_chat_id"] : null;
        $this->pinned_message = array_key_exists("pinned_message", $message) ? new Message($message["pinned_message"]) : null;
        $this->connected_website = array_key_exists("connected_website", $message) ? $message["connected_website"] : null;
        $this->proximity_alert_triggered = array_key_exists("proximity_alert_triggered", $message) ? new ProximityAlertTriggered($message["proximity_alert_triggered"]) : null;
        $this->voice_chat_scheduled = array_key_exists("voice_chat_scheduled", $message) ? new VoiceChatScheduled($message["voice_chat_scheduled"]) : null;
        $this->voice_chat_started = array_key_exists("voice_chat_started", $message) ? new VoiceChatStarted($message["voice_chat_started"]) : null;
        $this->voice_chat_ended = array_key_exists("voice_chat_ended", $message) ? new VoiceChatEnded($message["voice_chat_ended"]) : null;
        $this->voice_chat_participants_invited = array_key_exists("voice_chat_participants_invited", $message) ? new VoiceChatParticipantsInvited($message["voice_chat_participants_invited"]) : null;
        $this->reply_markup = array_key_exists("reply_markup", $message) ? new InlineKeyboardMarkup($message["reply_markup"]) : null;
    }
}

class MessageId {
    /*
        This object represents a unique message identifier.
    */

    public $message_id;

    function __construct($message_id) {
        $this->message_id = $message_id["message_id"];
    }
}

class MessageEntity {
    /*
        This object represents one special entity in a text message.
        For example, hashtags, usernames, URLs, etc.
    */

    public $type;
    public $offset;
    public $length;
    public $url;
    public $user;
    public $language;

    function __construct($message_entity) {
        $this->type = $message_entity["type"];
        $this->offset = $message_entity["offset"];
        $this->length = $message_entity["length"];
        $this->url = array_key_exists("url", $message_entity) ? $message_entity["url"] : null;
        $this->user = array_key_exists("user", $message_entity) ? new User($message_entity["user"]) : null;
        $this->language = array_key_exists("language", $message_entity) ? $message_entity["language"] : null;
    }

    public static function create($type, $offset, $length, $url = "", $user = [], $language = "") {
        /*
            $type: `str`[mention | hashtag | cashtag | bot_command | url | email | phone_number | bold | italic | underline | strikethrough | spoiler | code | pre | text_link | text_mention]
            $offset: `int`
            $length: `int`
            $url: Optional[`str`]
            $user: Optional[:method:`User.create()`]
            $language: Optional[`str`]
        */

        $message_entity = [
            "type" => $type,
            "offset" => $offset,
            "length" => $length
        ];
        if ($url) $message_entity["url"] = $url;
        if ($user) $message_entity["user"] = $user;
        if ($language) $message_entity["language"] = $language;
        return $message_entity;
    }
}

class PhotoSize {
    /*
        This object represents one size of a photo or a file / sticker
        thumbnail.
    */

    public $file_id;
    public $file_unique_id;
    public $width;
    public $height;
    public $file_size;

    function __construct($photo_size) {
        $this->file_id = $photo_size["file_id"];
        $this->file_unique_id = $photo_size["file_unique_id"];
        $this->width = $photo_size["width"];
        $this->height = $photo_size["height"];
        $this->file_size = array_key_exists("file_size", $photo_size) ? $photo_size["file_size"] : null;
    }
}

class Animation {
    /*
        This object represents an animation file (GIF or H.264/MPEG-4 AVC video
        without sound).
    */

    public $file_id;
    public $file_unique_id;
    public $width;
    public $height;
    public $duration;
    public $thumb;
    public $file_name;
    public $mime_type;
    public $file_size;

    function __construct($animation) {
        $this->file_id = $animation["file_id"];
        $this->file_unique_id = $animation["file_unique_id"];
        $this->width = $animation["width"];
        $this->height = $animation["height"];
        $this->duration = $animation["duration"];
        $this->thumb = array_key_exists("thumb", $animation) ? new PhotoSize($animation["thumb"]) : null;
        $this->file_name = array_key_exists("file_name", $animation) ? $animation["file_name"] : null;
        $this->mime_type = array_key_exists("mime_type", $animation) ? $animation["mime_type"] : null;
        $this->file_size = array_key_exists("file_size", $animation) ? $animation["file_size"] : null;
    }
}

class Audio {
    /*
        This object represents an audio file to be treated as music by the
        Telegram clients.
    */

    public $file_id;
    public $file_unique_id;
    public $duration;
    public $performer;
    public $title;
    public $file_name;
    public $mime_type;
    public $file_size;
    public $thumb;

    function __construct($audio) {
        $this->file_id = $audio["file_id"];
        $this->file_unique_id = $audio["file_unique_id"];
        $this->duration = $audio["duration"];
        $this->performer = array_key_exists("performer", $audio) ? $audio["performer"] : null;
        $this->title = array_key_exists("title", $audio) ? $audio["title"] : null;
        $this->file_name = array_key_exists("file_name", $audio) ? $audio["file_name"] : null;
        $this->mime_type = array_key_exists("mime_type", $audio) ? $audio["mime_type"] : null;
        $this->file_size = array_key_exists("file_size", $audio) ? $audio["file_size"] : null;
        $this->thumb = array_key_exists("thumb", $audio) ? new PhotoSize($audio["thumb"]) : null;
    }
}

class Document {
    /*
        This object represents a general file (as opposed to photos, voice
        messages and audio files).
    */

    public $file_id;
    public $file_unique_id;
    public $thumb;
    public $file_name;
    public $mime_type;
    public $file_size;

    function __construct($document) {
        $this->file_id = $document["file_id"];
        $this->file_unique_id = $document["file_unique_id"];
        $this->thumb = array_key_exists("thumb", $document) ? new PhotoSize($document["thumb"]) : null;
        $this->file_name = array_key_exists("file_name", $document) ? $document["file_name"] : null;
        $this->mime_type = array_key_exists("mime_type", $document) ? $document["mime_type"] : null;
        $this->file_size = array_key_exists("file_size", $document) ? $document["file_size"] : null;
    }
}

class Video {
    /*
        This object represents a video file.
    */

    public $file_id;
    public $file_unique_id;
    public $width;
    public $height;
    public $duration;
    public $thumb;
    public $file_name;
    public $mime_type;
    public $file_size;

    function __construct($video) {
        $this->file_id = $video["file_id"];
        $this->file_unique_id = $video["file_unique_id"];
        $this->width = $video["width"];
        $this->height = $video["height"];
        $this->duration = $video["duration"];
        $this->thumb = array_key_exists("thumb", $video) ? new PhotoSize($video["thumb"]) : null;
        $this->file_name = array_key_exists("file_name", $video) ? $video["file_name"] : null;
        $this->mime_type = array_key_exists("mime_type", $video) ? $video["mime_type"] : null;
        $this->file_size = array_key_exists("file_size", $video) ? $video["file_size"] : null;
    }
}

class VideoNote {
    /*
        This object represents a video message (available in Telegram apps as
        of v.4.0).
    */

    public $file_id;
    public $file_unique_id;
    public $length;
    public $duration;
    public $thumb;
    public $file_size;

    function __construct($video_note) {
        $this->file_id = $video_note["file_id"];
        $this->file_unique_id = $video_note["file_unique_id"];
        $this->length = $video_note["length"];
        $this->duration = $video_note["duration"];
        $this->thumb = array_key_exists("thumb", $video_note) ? new PhotoSize($video_note["thumb"]) : null;
        $this->file_size = array_key_exists("file_size", $video_note) ? $video_note["file_size"] : null;
    }
}

class Voice {
    /*
        This object represents a voice note.
    */

    public $file_id;
    public $file_unique_id;
    public $duration;
    public $mime_type;
    public $file_size;

    function __construct($voice) {
        $this->file_id = $voice["file_id"];
        $this->file_unique_id = $voice["file_unique_id"];
        $this->duration = $voice["duration"];
        $this->mime_type = array_key_exists("mime_type", $voice) ? $voice["mime_type"] : null;
        $this->file_size = array_key_exists("file_size", $voice) ? $voice["file_size"] : null;
    }
}

class Contact {
    /*
        This object represents a phone contact.
    */

    public $phone_number;
    public $first_name;
    public $last_name;
    public $user_id;
    public $vcard;

    function __construct($contact) {
        $this->phone_number = $contact["phone_number"];
        $this->first_name = $contact["first_name"];
        $this->last_name = array_key_exists("last_name", $contact) ? $contact["last_name"] : null;
        $this->user_id = array_key_exists("user_id", $contact) ? $contact["user_id"] : null;
        $this->vcard = array_key_exists("vcard", $contact) ? $contact["vcard"] : null;
    }
}

class Dice {
    /*
        This object represents an animated emoji that displays a random value.
    */

    public $emoji;
    public $value;

    function __construct($dice) {
        $this->emoji = $dice["emoji"];
        $this->value = $dice["value"];
    }
}

class PollOption {
    /*
        This object contains information about one answer option in a poll.
    */

    public $text;
    public $voter_count;

    function __construct($poll_option) {
        $this->text = $poll_option["text"];
        $this->voter_count = $poll_option["voter_count"];
    }
}

class PollAnswer {
    /*
        This object represents an answer of a user in a non-anonymous poll.
    */

    public $poll_id;
    public $user;
    public $option_ids;

    function __construct($poll_answer) {
        $this->poll_id = $poll_answer["poll_id"];
        $this->user = new User($poll_answer["user"]);
        $this->option_ids = $poll_answer["option_ids"];
    }
}

class Poll {
    /*
        This object contains information about a poll.
    */

    public $id;
    public $question;
    public $options;
    public $total_voter_count;
    public $is_closed;
    public $is_anonymous;
    public $type;
    public $allows_multiple_answers;
    public $correct_option_id;
    public $explanation;
    public $explanation_entities;
    public $open_period;
    public $close_date;

    function __construct($poll) {
        $this->id = $poll["id"];
        $this->question = $poll["question"];
        $this->options = classify($poll["options"], "PollOption");
        $this->total_voter_count = $poll["total_voter_count"];
        $this->is_closed = $poll["is_closed"];
        $this->is_anonymous = $poll["is_anonymous"];
        $this->type = $poll["type"];
        $this->allows_multiple_answers = $poll["allows_multiple_answers"];
        $this->correct_option_id = array_key_exists("correct_option_id", $poll) ? $poll["correct_option_id"] : null;
        $this->explanation = array_key_exists("explanation", $poll) ? $poll["explanation"] : null;
        $this->explanation_entities = array_key_exists("explanation_entities", $poll) ? classify($poll["explanation_entities"], "MessageEntity") : null;
        $this->open_period = array_key_exists("open_period", $poll) ? $poll["open_period"] : null;
        $this->close_date = array_key_exists("close_date", $poll) ? $poll["close_date"] : null;
    }
}

class Location {
    /*
        This object represents a point on the map.
    */

    public $longitude;
    public $latitude;
    public $horizontal_accuracy;
    public $live_period;
    public $heading;
    public $proximity_alert_radius;

    function __construct($location) {
        $this->longitude = $location["longitude"];
        $this->latitude = $location["latitude"];
        $this->horizontal_accuracy = array_key_exists("horizontal_accuracy", $location) ? $location["horizontal_accuracy"] : null;
        $this->live_period = array_key_exists("live_period", $location) ? $location["live_period"] : null;
        $this->heading = array_key_exists("heading", $location) ? $location["heading"] : null;
        $this->proximity_alert_radius = array_key_exists("proximity_alert_radius", $location) ? $location["proximity_alert_radius"] : null;
    }
}

class Venue {
    /*
        This object represents a venue.
    */

    public $location;
    public $title;
    public $address;
    public $foursquare_id;
    public $foursquare_type;
    public $google_place_id;
    public $google_place_type;

    function __construct($venue) {
        $this->location = new Location($venue["location"]);
        $this->title = $venue["title"];
        $this->address = $venue["address"];
        $this->foursquare_id = array_key_exists("foursquare_id", $venue) ? $venue["foursquare_id"] : null;
        $this->foursquare_type = array_key_exists("foursquare_type", $venue) ? $venue["foursquare_type"] : null;
        $this->google_place_id = array_key_exists("google_place_id", $venue) ? $venue["google_place_id"] : null;
        $this->google_place_type = array_key_exists("google_place_type", $venue) ? $venue["google_place_type"] : null;
    }
}

class ProximityAlertTriggered {
    /*
        This object represents the content of a service message, sent whenever
        a user in the chat triggers a proximity alert set by another user.
    */

    public $traveler;
    public $watcher;
    public $distance;

    function __construct($proximity_alert_triggered) {
        $this->traveler = new User($proximity_alert_triggered["traveler"]);
        $this->watcher = new User($proximity_alert_triggered["watcher"]);
        $this->distance = $proximity_alert_triggered["distance"];
    }
}

class MessageAutoDeleteTimerChanged {
    /*
        This object represents a service message about a change in auto-delete
        timer settings.
    */

    public $message_auto_delete_time;

    function __construct($message_auto_delete_timer_changed) {
        $this->message_auto_delete_time = $message_auto_delete_timer_changed["message_auto_delete_time"];
    }
}

class VoiceChatScheduled {
    /*
        This object represents a service message about a video chat scheduled
        in the chat.
    */

    public $start_date;

    function __construct($voice_chat_scheduled) {
        $this->start_date = $voice_chat_scheduled["start_date"];
    }
}

class VoiceChatStarted {
    /*
        This object represents a service message about a video chat started in
        the chat. Currently holds no information.
    */

    function __construct($voice_chat_started) {
    }
}

class VoiceChatEnded {
    /*
        This object represents a service message about a video chat ended in
        the chat.
    */

    public $duration;

    function __construct($voice_chat_ended) {
        $this->duration = $voice_chat_ended["duration"];
    }
}

class VoiceChatParticipantsInvited {
    /*
        This object represents a service message about new members invited to a
        video chat.
    */

    public $users;

    function __construct($voice_chat_participants_invited) {
        $this->users = array_key_exists("users", $voice_chat_participants_invited) ? classify($voice_chat_participants_invited["users"], "User") : null;
    }
}

class UserProfilePhotos {
    /*
        This object represent a user's profile pictures.
    */

    public $total_count;
    public $photos;

    function __construct($user_profile_photos) {
        $this->total_count = $user_profile_photos["total_count"];
        $this->photos = map($user_profile_photos["photos"], "classify", "PhotoSize");
    }
}

class File {
    /*
        This object represents a file ready to be downloaded. The file can be
        downloaded via the link https://api.telegram.org/file/bot<token>/<file_path>.
        It is guaranteed that the link will be valid for at least 1 hour. When
        the link expires, a new one can be requested by calling getFile.
    */

    public $file_id;
    public $file_unique_id;
    public $file_size;
    public $file_path;

    function __construct($file) {
        $this->file_id = $file["file_id"];
        $this->file_unique_id = $file["file_unique_id"];
        $this->file_size = array_key_exists("file_size", $file) ? $file["file_size"] : null;
        $this->file_path = array_key_exists("file_path", $file) ? $file["file_path"] : null;
    }
}

class ReplyKeyboardMarkup {
    /*
        This object represents a custom keyboard with reply options (see
        Introduction to bots for details and examples).
    */

    function __construct($reply_keyboard_markup) {
    }

    public static function create($keyboard, $resize_keyboard = false, $one_time_keyboard = false, $input_field_placeholder = "", $selective = false) {
        /*
            $keyboard: `array`[*`array`[*:method:`KeyboardButton.create()`]]
            $resize_keyboard: Optional[`bool`] Default: false
            $one_time_keyboard: Optional[`bool`] Default: false
            $input_field_placeholder: Optional[`str`] 1-64 characters
            $selective: Optional[`bool`] Default: false
        */

        $reply_keyboard_markup = [
            "keyboard" => $keyboard
        ];
        if ($resize_keyboard) $reply_keyboard_markup["resize_keyboard"] = $resize_keyboard;
        if ($one_time_keyboard) $reply_keyboard_markup["one_time_keyboard"] = $one_time_keyboard;
        if ($input_field_placeholder) $reply_keyboard_markup["input_field_placeholder"] = $input_field_placeholder;
        if ($selective) $reply_keyboard_markup["selective"] = $selective;
        return $reply_keyboard_markup;
    }
}

class KeyboardButton {
    /*
        This object represents one button of the reply keyboard. For simple text
        buttons String can be used instead of this object to specify text of the
        button. Optional fields request_contact, request_location, and
        request_poll are mutually exclusive.
    */

    function __construct($keyboard_button) {
    }

    public static function create($text, $request_contact = false, $request_location = false, $request_poll = []) {
        /*
            $text: `str`
            $request_contact: Optional[`bool`] Default: false
            $request_location: Optional[`bool`] Default: false
            $request_poll: Optional[:method:`KeyboardButtonPollType.create()`]
        */

        $keyboard_button = [
            "text" => $text
        ];
        if ($request_contact) $keyboard_button["request_contact"] = $request_contact;
        if ($request_location) $keyboard_button["request_location"] = $request_location;
        if ($request_poll) $keyboard_button["request_poll"] = $request_poll;
        return $keyboard_button;
    }
}

class KeyboardButtonPollType {
    /*
        This object represents type of a poll, which is allowed to be created
        and sent when the corresponding button is pressed.
    */

    function __construct($keyboard_button_poll_type) {
    }

    public static function create($type = "") {
        /*
            $type: Optional[`str`[quiz | regular]]
        */

        $keyboard_button_poll_type = [];
        if ($type) $keyboard_button_poll_type["type"] = $type;
        return $keyboard_button_poll_type;
    }
}

class ReplyKeyboardRemove {
    /*
        Upon receiving a message with this object, Telegram clients will remove
        the current custom keyboard and display the default letter-keyboard. By
        default, custom keyboards are displayed until a new keyboard is sent by
        a bot. An exception is made for one-time keyboards that are hidden
        immediately after the user presses a button (see ReplyKeyboardMarkup).
    */

    function __construct($reply_keyboard_remove) {
    }

    public static function create($remove_keyboard, $selective = false) {
        /*
            $remove_keyboard: `bool`[true]
            $selective: `bool` Default: false
        */

        $reply_keyboard_remove = [
            "remove_keyboard" => $remove_keyboard
        ];
        if ($selective) $reply_keyboard_remove["selective"] = $selective;
        return $reply_keyboard_remove;
    }
}

class InlineKeyboardMarkup {
    /*
        This object represents an inline keyboard that appears right next to
        the message it belongs to.
    */

    public $inline_keyboard;

    function __construct($inline_keyboard_markup) {
        $this->inline_keyboard = map($inline_keyboard_markup["inline_keyboard"], "classify", "InlineKeyboardButton");
    }

    public static function create($inline_keyboard) {
        /*
            $inline_keyboard: `array`[*`array`[*:method:`InlineKeyboardButton.create()`]]
        */

        $inline_keyboard_markup = [
            "inline_keyboard" => $inline_keyboard
        ];
        return $inline_keyboard_markup;
    }
}

class InlineKeyboardButton {
    /*
        This object represents one button of an inline keyboard. You must use
        exactly one of the optional fields.
    */

    public $text;
    public $url;
    public $callback_data;
    public $login_url;
    public $switch_inline_query;
    public $switch_inline_query_current_chat;

    function __construct($inline_keyboard_button) {
        $this->text = $inline_keyboard_button["text"];
        $this->url = array_key_exists("url", $inline_keyboard_button) ? $inline_keyboard_button["url"] : null;
        $this->callback_data = array_key_exists("callback_data", $inline_keyboard_button) ? $inline_keyboard_button["callback_data"] : null;
        $this->login_url = array_key_exists("login_url", $inline_keyboard_button) ? new LoginUrl($inline_keyboard_button["login_url"]) : null;
        $this->switch_inline_query = array_key_exists("switch_inline_query", $inline_keyboard_button) ? $inline_keyboard_button["switch_inline_query"] : null;
        $this->switch_inline_query_current_chat = array_key_exists("switch_inline_query_current_chat", $inline_keyboard_button) ? $inline_keyboard_button["switch_inline_query_current_chat"] : null;
    }

    public static function create($text, $url = "", $callback_data = "", $login_url = [], $switch_inline_query = "", $switch_inline_query_current_chat = "", $callback_game = []) {
        /*
            $text: `str`
            $url: Optional[`str`]
            $callback_data: Optional[`str`]
            $login_url: Optional[:method:`LoginUrl.create()`]
            $switch_inline_query: Optional[`str`]
            $switch_inline_query_current_chat: Optional[`str`]
            $callback_game: Optional[:method:`CallbackGame.create()`]
        */

        $inline_keyboard_button = [
            "text" => $text
        ];
        if ($url) $inline_keyboard_button["url"] = $url;
        if ($login_url) $inline_keyboard_button["login_url"] = $login_url;
        if ($callback_data) $inline_keyboard_button["callback_data"] = $callback_data;
        if ($switch_inline_query) $inline_keyboard_button["switch_inline_query"] = $switch_inline_query;
        if ($switch_inline_query_current_chat) $inline_keyboard_button["switch_inline_query_current_chat"] = $switch_inline_query_current_chat;
        if ($callback_game) $inline_keyboard_button["callback_game"] = $callback_game;
        return $inline_keyboard_button;
    }
}

class LoginUrl {
    /*
        This object represents a parameter of the inline keyboard button used
        to automatically authorize a user.
    */

    public $url;
    public $forward_text;
    public $bot_username;
    public $request_write_access;

    function __construct($login_url) {
        $this->url = $login_url["url"];
        $this->forward_text = array_key_exists("forward_text", $login_url) ? $login_url["forward_text"] : null;
        $this->bot_username = array_key_exists("bot_username", $login_url) ? $login_url["bot_username"] : null;
        $this->request_write_access = array_key_exists("request_write_access", $login_url) ? $login_url["request_write_access"] : null;
    }

    public static function create($url, $forward_text = "", $bot_username = "", $request_write_access = false) {
        /*
            $url: `str`
            $forward_text: Optional[`str`]
            $bot_username: Optional[`str`]
            $request_write_access: Optional[`bool`] Default: false
        */

        $login_url = [
            "url" => $url
        ];
        if ($forward_text) $login_url["forward_text"] = $forward_text;
        if ($bot_username) $login_url["bot_username"] = $bot_username;
        if ($request_write_access) $login_url["request_write_access"] = $request_write_access;
        return $login_url;
    }
}

class CallbackQuery {
    /*
        This object represents an incoming callback query from a callback button
        in an inline keyboard. If the button that originated the query was
        attached to a message sent by the bot, the field message will be present.
        If the button was attached to a message sent via the bot (in inline mode)
        , the field inline_message_id will be present. Exactly one of the fields
        data or game_short_name will be present.
    */

    public $id;
    public $from;
    public $message;
    public $inline_message_id;
    public $chat_instance;
    public $data;
    public $game_short_name;

    function __construct($callback_query) {
        $this->id = $callback_query["id"];
        $this->from = new User($callback_query["from"]);
        $this->message = array_key_exists("message", $callback_query) ? new Message($callback_query["message"]) : null;
        $this->inline_message_id = array_key_exists("inline_message_id", $callback_query) ? $callback_query["inline_message_id"] : null;
        $this->chat_instance = $callback_query["chat_instance"];
        $this->data = array_key_exists("data", $callback_query) ? $callback_query["data"] : null;
        $this->game_short_name = array_key_exists("game_short_name", $callback_query) ? $callback_query["game_short_name"] : null;
    }
}

class ForceReply {
    /*
        Upon receiving a message with this object, Telegram clients will display
        a reply interface to the user (act as if the user has selected the bot's
        message and tapped 'Reply'). This can be extremely useful if you want to
        create user-friendly step-by-step interfaces without having to sacrifice
        privacy mode.
    */

    function __construct($forcereply) {
    }

    public static function create($force_reply, $input_field_placeholder = "", $selective = false) {
        /*
            $force_reply: `bool`[true]
            $input_field_placeholder: Optional[`str`] 1-64 character
            $selective: Optional[`bool`] Default: false
        */

        $forcereply = [
            "force_reply" => $force_reply
        ];
        if ($input_field_placeholder) $forcereply["input_field_placeholder"] = $input_field_placeholder;
        if ($selective) $forcereply["selective"] = $selective;
        return $forcereply;
    }
}

class ChatPhoto {
    /*
        This object represents a chat photo.
    */

    public $small_file_id;
    public $small_file_unique_id;
    public $big_file_id;
    public $big_file_unique_id;

    function __construct($chat_photo) {
        $this->small_file_id = $chat_photo["small_file_id"];
        $this->small_file_unique_id = $chat_photo["small_file_unique_id"];
        $this->big_file_id = $chat_photo["big_file_id"];
        $this->big_file_unique_id = $chat_photo["big_file_unique_id"];
    }
}

class ChatInviteLink {
    /*
        Represents an invite link for a chat.
    */

    public $invite_link;
    public $creator;
    public $creates_join_request;
    public $is_primary;
    public $is_revoked;
    public $name;
    public $expire_date;
    public $member_limit;
    public $pending_join_request_count;

    function __construct($chat_invite_link) {
        $this->invite_link = $chat_invite_link["invite_link"];
        $this->creator = new User($chat_invite_link["creator"]);
        $this->creates_join_request = $chat_invite_link["creates_join_request"];
        $this->is_primary = $chat_invite_link["is_primary"];
        $this->is_revoked = $chat_invite_link["is_revoked"];
        $this->name = array_key_exists("name", $chat_invite_link) ? $chat_invite_link["name"] : null;
        $this->expire_date = array_key_exists("expire_date", $chat_invite_link) ? $chat_invite_link["expire_date"] : null;
        $this->member_limit = array_key_exists("member_limit", $chat_invite_link) ? $chat_invite_link["member_limit"] : null;
        $this->pending_join_request_count = array_key_exists("pending_join_request_count", $chat_invite_link) ? $chat_invite_link["pending_join_request_count"] : null;
    }
}

class ChatAdministratorRights {
    /*
        Represents the rights of an administrator in a chat.
    */

    public $is_anonymous;
    public $can_manage_chat;
    public $can_delete_messages;
    public $can_manage_video_chats;
    public $can_restrict_members;
    public $can_promote_members;
    public $can_change_info;
    public $can_invite_users;
    public $can_post_messages;
    public $can_edit_messages;
    public $can_pin_messages;

    function __construct($chat_administrator_rights) {
        $this->is_anonymous = $chat_administrator_rights["is_anonymous"];
        $this->can_manage_chat = $chat_administrator_rights["can_manage_chat"];
        $this->can_delete_messages = $chat_administrator_rights["can_delete_messages"];
        $this->can_manage_video_chats = $chat_administrator_rights["can_manage_video_chats"];
        $this->can_restrict_members = $chat_administrator_rights["can_restrict_members"];
        $this->can_promote_members = $chat_administrator_rights["can_promote_members"];
        $this->can_change_info = $chat_administrator_rights["can_change_info"];
        $this->can_invite_users = $chat_administrator_rights["can_invite_users"];
        $this->can_post_messages = array_key_exists("can_post_messages", $chat_administrator_rights) ? $chat_administrator_rights["can_post_messages"] : null;
        $this->can_edit_messages = array_key_exists("can_edit_messages", $chat_administrator_rights) ? $chat_administrator_rights["can_edit_messages"] : null;
        $this->can_pin_messages = array_key_exists("can_pin_messages", $chat_administrator_rights) ? $chat_administrator_rights["can_pin_messages"] : null;
    }

    public static function create($is_anonymous, $can_manage_chat, $can_delete_messages, $can_manage_video_chats, $can_restrict_members, $can_promote_members, $can_change_info, $can_invite_users, $can_post_messages = false, $can_edit_messages = false, $can_pin_messages = false) {
        /*
            $is_anonymous: `bool`[true]
            $can_manage_chat: `bool`[true]
            $can_delete_messages: `bool`[true]
            $can_manage_video_chats: `bool`[true]
            $can_restrict_members: `bool`[true]
            $can_promote_members: `bool`[true]
            $can_change_info: `bool`[true]
            $can_invite_users: `bool`[true]
            $can_post_messages: Optional[`bool`] Default: false
            $can_edit_messages: Optional[`bool`] Default: false
            $can_pin_messages: Optional[`bool`] Default: false
        */

        $chat_administrator_rights = [
            "is_anonymous" => $is_anonymous,
            "can_manage_chat" => $can_manage_chat,
            "can_delete_messages" => $can_delete_messages,
            "can_manage_video_chats" => $can_manage_video_chats,
            "can_restrict_members" => $can_restrict_members,
            "can_promote_members" => $can_promote_members,
            "can_change_info" => $can_change_info,
            "can_invite_users" => $can_invite_users
        ];
        if ($can_post_messages) $chat_administrator_rights["can_post_messages"];
        if ($can_edit_messages) $chat_administrator_rights["can_edit_messages"];
        if ($can_pin_messages) $chat_administrator_rights["can_pin_messages"];
        return $chat_administrator_rights;
    }
}

class ChatMember {
    /*
        This object contains information about one member of a chat.
    */

    public $status;
    public $user;
    public $is_anonymous;
    public $custom_title;
    public $is_member;
    public $until_date;
    public $can_be_edited;
    public $can_manage_chat;
    public $can_delete_messages;
    public $can_manage_voice_chats;
    public $can_restrict_members;
    public $can_promote_members;
    public $can_change_info;
    public $can_invite_users;
    public $can_post_messages;
    public $can_edit_messages;
    public $can_pin_messages;
    public $can_send_messages;
    public $can_send_media_messages;
    public $can_send_polls;
    public $can_send_other_messages;
    public $can_add_web_page_previews;

    function __construct($chat_member) {
        $this->status = $chat_member["status"];
        $this->user = new User($chat_member["user"]);
        $this->is_anonymous = array_key_exists("is_anonymous", $chat_member) ? $chat_member["is_anonymous"] : null;
        $this->custom_title = array_key_exists("custom_title", $chat_member) ? $chat_member["custom_title"] : null;
        $this->is_member = array_key_exists("is_member", $chat_member) ? $chat_member["is_member"] : null;
        $this->until_date = array_key_exists("until_date", $chat_member) ? $chat_member["until_date"] : null;
        $this->can_be_edited = array_key_exists("can_be_edited", $chat_member) ? $chat_member["can_be_edited"] : null;
        $this->can_manage_chat = array_key_exists("can_manage_chat", $chat_member) ? $chat_member["can_manage_chat"] : null;
        $this->can_delete_messages = array_key_exists("can_delete_messages", $chat_member) ? $chat_member["can_delete_messages"] : null;
        $this->can_manage_voice_chats = array_key_exists("can_manage_voice_chats", $chat_member) ? $chat_member["can_manage_voice_chats"] : null;
        $this->can_restrict_members = array_key_exists("can_restrict_members", $chat_member) ? $chat_member["can_restrict_members"] : null;
        $this->can_promote_members = array_key_exists("can_promote_members", $chat_member) ? $chat_member["can_promote_members"] : null;
        $this->can_change_info = array_key_exists("can_change_info", $chat_member) ? $chat_member["can_change_info"] : null;
        $this->can_invite_users = array_key_exists("can_invite_users", $chat_member) ? $chat_member["can_invite_users"] : null;
        $this->can_post_messages = array_key_exists("can_post_messages", $chat_member) ? $chat_member["can_post_messages"] : null;
        $this->can_edit_messages = array_key_exists("can_edit_messages", $chat_member) ? $chat_member["can_edit_messages"] : null;
        $this->can_pin_messages = array_key_exists("can_pin_messages", $chat_member) ? $chat_member["can_pin_messages"] : null;
        $this->can_send_messages = array_key_exists("can_send_messages", $chat_member) ? $chat_member["can_send_messages"] : null;
        $this->can_send_media_messages = array_key_exists("can_send_media_messages", $chat_member) ? $chat_member["can_send_media_messages"] : null;
        $this->can_send_polls = array_key_exists("can_send_polls", $chat_member) ? $chat_member["can_send_polls"] : null;
        $this->can_send_other_messages = array_key_exists("can_send_other_messages", $chat_member) ? $chat_member["can_send_other_messages"] : null;
        $this->can_add_web_page_previews = array_key_exists("can_add_web_page_previews", $chat_member) ? $chat_member["can_add_web_page_previews"] : null;
    }
}

class ChatMemberUpdated {
    /*
        This object represents changes in the status of a chat member.
    */

    public $chat;
    public $from;
    public $date;
    public $old_chat_member;
    public $new_chat_member;
    public $invite_link;

    function __construct($chat_member_updated) {
        $this->chat = new Chat($chat_member_updated["chat"]);
        $this->from = new User($chat_member_updated["from"]);
        $this->date = $chat_member_updated["date"];
        $this->old_chat_member = new ChatMember($chat_member_updated["old_chat_member"]);
        $this->new_chat_member = new ChatMember($chat_member_updated["new_chat_member"]);
        $this->invite_link = array_key_exists("invite_link", $chat_member_updated) ? new ChatInviteLink($chat_member_updated["invite_link"]) : null;
    }
}

class ChatJoinRequest {
    /*
        Represents a join request sent to a chat.
    */

    public $chat;
    public $from;
    public $date;
    public $bio;
    public $invite_link;

    function __construct($chat_join_request) {
        $this->chat = new Chat($chat_join_request["chat"]);
        $this->from = new User($chat_join_request["from"]);
        $this->date = $chat_join_request["date"];
        $this->bio = array_key_exists("bio", $chat_join_request) ? $chat_join_request["bio"] : null;
        $this->invite_link = array_key_exists("invite_link", $chat_join_request) ? $chat_join_request["invite_link"] : null;
    }
}

class ChatPermissions {
    /*
        Describes actions that a non-administrator user is allowed to take in a
        chat.
    */

    public $can_send_messages;
    public $can_send_media_messages;
    public $can_send_polls;
    public $can_send_other_messages;
    public $can_add_web_page_previews;
    public $can_change_info;
    public $can_invite_users;
    public $can_pin_messages;

    function __construct($chat_permissions) {
        $this->can_send_messages = array_key_exists("can_send_messages", $chat_permissions) ? $chat_permissions["can_send_messages"] : null;
        $this->can_send_media_messages = array_key_exists("can_send_media_messages", $chat_permissions) ? $chat_permissions["can_send_media_messages"] : null;
        $this->can_send_polls = array_key_exists("can_send_polls", $chat_permissions) ? $chat_permissions["can_send_polls"] : null;
        $this->can_send_other_messages = array_key_exists("can_send_other_messages", $chat_permissions) ? $chat_permissions["can_send_other_messages"] : null;
        $this->can_add_web_page_previews = array_key_exists("can_add_web_page_previews", $chat_permissions) ? $chat_permissions["can_add_web_page_previews"] : null;
        $this->can_change_info = array_key_exists("can_change_info", $chat_permissions) ? $chat_permissions["can_change_info"] : null;
        $this->can_invite_users = array_key_exists("can_invite_users", $chat_permissions) ? $chat_permissions["can_invite_users"] : null;
        $this->can_pin_messages = array_key_exists("can_pin_messages", $chat_permissions) ? $chat_permissions["can_pin_messages"] : null;
    }

    public static function create($can_send_messages = false, $can_send_media_messages = false, $can_send_polls = false, $can_send_other_messages = false, $can_add_web_page_previews = false, $can_change_info = false, $can_invite_users = false, $can_pin_messages = false) {
        /*
            $can_send_messages: Optional[`bool`] Default: false
            $can_send_media_messages: Optional[`bool`] Default: false
            $can_send_polls: Optional[`bool`] Default: false
            $can_send_other_messages: Optional[`bool`] Default: false
            $can_add_web_page_previews: Optional[`bool`] Default: false
            $can_change_info: Optional[`bool`] Default: false
            $can_invite_users: Optional[`bool`] Default: false
            $can_pin_messages: Optional[`bool`] Default: false
        */

        $chat_permissions = [];
        if ($can_send_messages) $chat_permissions["can_send_messages"] = $can_send_messages;
        if ($can_send_media_messages) $chat_permissions["can_send_media_messages"] = $can_send_media_messages;
        if ($can_send_polls) $chat_permissions["can_send_polls"] = $can_send_polls;
        if ($can_send_other_messages) $chat_permissions["can_send_other_messages"] = $can_send_other_messages;
        if ($can_add_web_page_previews) $chat_permissions["can_add_web_page_previews"] = $can_add_web_page_previews;
        if ($can_change_info) $chat_permissions["can_change_info"] = $can_change_info;
        if ($can_invite_users) $chat_permissions["can_invite_users"] = $can_invite_users;
        if ($can_pin_messages) $chat_permissions["can_pin_messages"] = $can_pin_messages;
        return $chat_permissions;
    }
}

class ChatLocation {
    /*
        Represents a location to which a chat is connected.
    */

    public $location;
    public $address;

    function __construct($chat_location) {
        $this->location = new Location($chat_location["location"]);
        $this->address = $chat_location["address"];
    }
}

class BotCommand {
    /*
        This object represents a bot command.
    */

    public $command;
    public $description;

    function __construct($bot_command) {
        $this->command = $bot_command["command"];
        $this->description = $bot_command["description"];
    }

    public static function create($command, $description) {
        /*
            $command: `str` 1-32 characters
            $description: `str` 1-256 characters
        */

        $bot_command = [
            "command" => $command,
            "description" => $description
        ];
        return $bot_command;
    }
}

class BotCommandScopeDefault {
    /*
        Represents the default scope of bot commands. Default commands are used
        if no commands with a narrower scope are specified for the user.
    */

    function __construct($bot_command_scope_default) {
    }

    public static function create() {
        $bot_command_scope_default = [
            "type" => "default"
        ];
        return $bot_command_scope_default;
    }
}

class BotCommandScopeAllPrivateChats {
    /*
        Represents the scope of bot commands, covering all private chats.
    */

    function __construct($bot_command_scope_all_private_chats) {
    }

    public static function create() {
        $bot_command_scope_all_private_chats = [
            "type" => "all_private_chats"
        ];
        return $bot_command_scope_all_private_chats;
    }
}

class BotCommandScopeAllGroupChats {
    /*
        Represents the scope of bot commands, covering all group and supergroup
        chats.
    */

    function __construct($bot_command_scope_all_group_chats) {
    }

    public static function create() {
        $bot_command_scope_all_group_chats = [
            "type" => "all_group_chats"
        ];
        return $bot_command_scope_all_group_chats;
    }
}

class BotCommandScopeAllChatAdministrators {
    /*
        Represents the scope of bot commands, covering all group and supergroup
        chat administrators.
    */

    function __construct($bot_command_scope_all_chat_administrators) {
    }

    public static function create() {
        $bot_command_scope_all_chat_administrators = [
            "type" => "all_chat_administrators"
        ];
        return $bot_command_scope_all_chat_administrators;
    }
}

class BotCommandScopeChat {
    /*
        Represents the scope of bot commands, covering a specific chat.
    */

    function __construct($bot_command_scope_chat) {
    }

    public static function create($chat_id) {
        /*
            $chat_id: `int` OR `str`<Supergroup username>
        */

        $bot_command_scope_chat = [
            "type" => "chat",
            "chat_id" => $chat_id
        ];
        return $bot_command_scope_chat;
    }
}

class BotCommandScopeChatAdministrators {
    /*
        Represents the scope of bot commands, covering all administrators of a
        specific group or supergroup chat.
    */

    function __construct($bot_command_scope_chat_administrators) {
    }

    public static function create($chat_id) {
        /*
            $chat_id: `int` OR `str`<Supergroup username>
        */

        $bot_command_scope_chat_administrators = [
            "type" => "chat",
            "chat_id" => $chat_id
        ];
        return $bot_command_scope_chat_administrators;
    }
}

class BotCommandScopeChatMember {
    /*
        Represents the scope of bot commands, covering all administrators of a
        specific group or supergroup chat.
    */

    function __construct($bot_command_scope_chat_member) {
    }

    public static function create($chat_id, $user_id) {
        /*
            $chat_id: `int` OR `str`<Supergroup username>
            $user_id: `int`
        */

        $bot_command_scope_chat_member = [
            "type" => "chat",
            "chat_id" => $chat_id,
            "user_id" => $user_id
        ];
        return $bot_command_scope_chat_member;
    }
}

class MenuButton {
    /*
        This object describes the bot's menu button in a private chat.
    */

    public $type;

    function __construct($menu_button) {
        $this->type = $menu_button["type"];
    }
}

class MenuButtonCommands {
    /*
        Represents a menu button, which opens the bot's list of commands.
    */

    function __construct($menu_button_commands) {
    }

    public static function create() {
        $menu_button_commands = [
            "type" => "commands"
        ];
        return $menu_button_commands;
    }
}

class MenuButtonDefault {
    /*
        Describes that no specific value for the menu button was set.
    */

    function __construct($menu_button_default) {
    }

    public static function create() {
        $menu_button_default = [
            "type" => "default"
        ];
        return $menu_button_default;
    }
}

class ResponseParameters {
    /*
        Describes why a request was unsuccessful.
    */

    public $migrate_to_chat_id;
    public $retry_after;

    function __construct($response_parameters) {
        $this->migrate_to_chat_id = array_key_exists("migrate_to_chat_id", $response_parameters) ? $response_parameters["migrate_to_chat_id"] : null;
        $this->retry_after = array_key_exists("retry_after", $response_parameters) ? $response_parameters["retry_after"] : null;
    }
}

class InputMediaPhoto {
    /*
        Represents a photo to be sent.
    */

    function __construct($input_media_photo) {
    }

    public static function create($media, $caption = "", $parse_mode = "", $caption_entities = []) {
        /*
            $media: `str`[<file_id> | <File URL>]
            $caption: Optional[`str`] 0-1024 characters
            $parse_mode: Optional[`str`[Markdown | MarkdownV2 | HTML]]
            $caption_entities: Optional[`array`[*:method:`MessageEntity.create()`]]
        */

        $input_media_photo = [
            "type" => "photo",
            "media" => $media
        ];
        if ($caption) $input_media_photo["caption"] = $caption;
        if ($parse_mode) $input_media_photo["parse_mode"] = $parse_mode;
        if ($caption_entities) $input_media_photo["caption_entities"] = $caption_entities;
        return $input_media_photo;
    }
}

class InputMediaVideo {
    /*
        Represents a video to be sent.
    */

    function __construct($input_media_video) {
    }

    public static function create($media, $thumb = "", $caption = "", $parse_mode = "", $caption_entities = [], $width = "", $height = "", $duration = "", $supports_streaming = false) {
        /*
            $media: `str`[<file_id> | <File URL>]
            $thumb: Optional[`str`[<file_id> | <File URL>]]
            $caption: Optional[`str`] 0-1024 characters
            $parse_mode: Optional[`str`[Markdown | MarkdownV2 | HTML]]
            $caption_entities: Optional[`array`[*:method:`MessageEntity.create()`]]
            $width: Optional[`int`]
            $height: Optional[`int`]
            $duration: Optional[`int`]
            $supports_streaming: Optional[`bool`] Default: false
        */

        $input_media_video = [
            "type" => "video",
            "media" => $media
        ];
        if ($thumb) $input_media_video["thumb"] = $thumb;
        if ($caption) $input_media_video["caption"] = $caption;
        if ($parse_mode) $input_media_video["parse_mode"] = $parse_mode;
        if ($caption_entities) $input_media_video["caption_entities"] = $caption_entities;
        if ($width) $input_media_video["width"] = $width;
        if ($height) $input_media_video["height"] = $height;
        if ($duration) $input_media_video["duration"] = $duration;
        if ($supports_streaming) $input_media_video["supports_streaming"] = $supports_streaming;
        return $input_media_video;
    }
}

class InputMediaAnimation {
    /*
        Represents an animation file (GIF or H.264/MPEG-4 AVC video without
        sound) to be sent.
    */

    function __construct($input_media_animation) {
    }

    public static function create($media, $thumb = "", $caption = "", $parse_mode = "", $caption_entities = [], $width = "", $height = "", $duration = "") {
        /*
            $media: `str`[<file_id> | <File URL>]
            $thumb: Optional[`str`[<file_id> | <File URL>]]
            $caption: Optional[`str`] 0-1024 characters
            $parse_mode: Optional[`str`[Markdown | MarkdownV2 | HTML]]
            $caption_entities: Optional[`array`[*:method:`MessageEntity.create()`]]
            $width: Optional[`int`]
            $height: Optional[`int`]
            $duration: Optional[`int`]
        */

        $input_media_animation = [
            "type" => "animation",
            "media" => $media
        ];
        if ($thumb) $input_media_animation["thumb"] = $thumb;
        if ($caption) $input_media_animation["caption"] = $caption;
        if ($parse_mode) $input_media_animation["parse_mode"] = $parse_mode;
        if ($caption_entities) $input_media_animation["caption_entities"] = $caption_entities;
        if ($width) $input_media_animation["width"] = $width;
        if ($height) $input_media_animation["height"] = $height;
        if ($duration) $input_media_animation["duration"] = $duration;
        return $input_media_animation;
    }
}

class InputMediaAudio {
    /*
        Represents an audio file to be treated as music to be sent.
    */

    function __construct($input_media_audio) {
    }

    public static function create($media, $thumb = "", $caption = "", $parse_mode = "", $caption_entities = [], $duration = "", $performer = "", $title = "") {
        /*
            $media: `str`[<file_id> | <File URL>]
            $thumb: Optional[`str`[<file_id> | <File URL>]]
            $caption: Optional[`str`] 0-1024 characters
            $parse_mode: Optional[`str`[Markdown | MarkdownV2 | HTML]]
            $caption_entities: Optional[`array`[*:method:`MessageEntity.create()`]]
            $duration: Optional[`int`]
            $performer: Optional[`str`]
            $title: Optional[`str`]
        */

        $input_media_audio = [
            "type" => "audio",
            "media" => $media
        ];
        if ($thumb) $input_media_audio["thumb"] = $thumb;
        if ($caption) $input_media_audio["caption"] = $caption;
        if ($parse_mode) $input_media_audio["parse_mode"] = $parse_mode;
        if ($caption_entities) $input_media_audio["caption_entities"] = $caption_entities;
        if ($duration) $input_media_audio["duration"] = $duration;
        if ($performer) $input_media_audio["performer"] = $performer;
        if ($title) $input_media_audio["title"] = $title;
        return $input_media_audio;
    }
}

class InputMediaDocument {
    /*
        Represents a general file to be sent.
    */

    function __construct($input_media_document) {
    }

    public static function create($media, $thumb = "", $caption = "", $parse_mode = "", $caption_entities = [], $disable_content_type_detection = false) {
        /*
            $media: `str`[<file_id> | <File URL>]
            $thumb: Optional[`str`[<file_id> | <File URL>]]
            $caption: Optional[`str`] 0-1024 characters
            $parse_mode: Optional[`str`[Markdown | MarkdownV2 | HTML]]
            $caption_entities: Optional[`array`[*:method:`MessageEntity.create()`]]
            $disable_content_type_detection: Optional[`bool`] Default: false
        */

        $input_media_document = [
            "type" => "document",
            "media" => $media
        ];
        if ($thumb) $input_media_document["thumb"] = $thumb;
        if ($caption) $input_media_document["caption"] = $caption;
        if ($parse_mode) $input_media_document["parse_mode"] = $parse_mode;
        if ($caption_entities) $input_media_document["caption_entities"] = $caption_entities;
        if ($disable_content_type_detection) $input_media_document["disable_content_type_detection"] = $disable_content_type_detection;
        return $input_media_document;
    }
}

class Sticker {
    /*
        This object represents a sticker.
    */

    public $file_id;
    public $file_unique_id;
    public $width;
    public $height;
    public $is_animated;
    public $is_video;
    public $thumb;
    public $emoji;
    public $set_name;
    public $premium_animation;
    public $mask_position;
    public $file_size;

    function __construct($sticker) {
        $this->file_id = $sticker["file_id"];
        $this->file_unique_id = $sticker["file_unique_id"];
        $this->width = $sticker["width"];
        $this->height = $sticker["height"];
        $this->is_animated = $sticker["is_animated"];
        $this->is_video = $sticker["is_video"];
        $this->thumb = array_key_exists("thumb", $sticker) ? new PhotoSize($sticker["thumb"]) : null;
        $this->emoji = array_key_exists("emoji", $sticker) ? $sticker["emoji"] : null;
        $this->set_name = array_key_exists("set_name", $sticker) ? $sticker["set_name"] : null;
        $this->premium_animation = array_key_exists("premium_animation", $sticker) ? new File($sticker["premium_animation"]) : null;
        $this->mask_position = array_key_exists("mask_position", $sticker) ? new MaskPosition($sticker["mask_position"]) : null;
        $this->file_size = array_key_exists("file_size", $sticker) ? $sticker["file_size"] : null;
    }
}

class StickerSet {
    /*
        This object represents a sticker set.
    */

    public $name;
    public $title;
    public $is_animated;
    public $is_video;
    public $contains_masks;
    public $stickers;
    public $thumb;

    function __construct($sticker_set) {
        $this->name = $sticker_set["name"];
        $this->title = $sticker_set["title"];
        $this->is_animated = $sticker_set["is_animated"];
        $this->is_video = $sticker_set["is_video"];
        $this->contains_masks = $sticker_set["contains_masks"];
        $this->stickers = classify($sticker_set["stickers"], "Sticker");
        $this->thumb = array_key_exists("thumb", $sticker_set) ? new PhotoSize($sticker_set["thumb"]) : null;
    }
}

class MaskPosition {
    /*
        This object describes the position on faces where a mask should be
        placed by default.
    */

    public $point;
    public $x_shift;
    public $y_shift;
    public $scale;

    function __construct($mask_position) {
        $this->point = $mask_position["point"];
        $this->x_shift = $mask_position["x_shift"];
        $this->y_shift = $mask_position["y_shift"];
        $this->scale = $mask_position["scale"];
    }
}

class InlineQuery {
    /*
        This object represents an incoming inline query. When the user sends an
        empty query, your bot could return some default or trending results.
    */

    public $id;
    public $from;
    public $query;
    public $offset;
    public $chat_type;
    public $location;

    function __construct($inline_query) {
        $this->id = $inline_query["id"];
        $this->from = new User($inline_query["from"]);
        $this->query = $inline_query["query"];
        $this->offset = $inline_query["offset"];
        $this->chat_type = array_key_exists("chat_type", $inline_query) ? $inline_query["chat_type"] : null;
        $this->location = array_key_exists("location", $inline_query) ? new Location($inline_query["location"]) : null;
    }
}

class InlineQueryResultArticle {
    /*
        Represents a link to an article or web page.
    */

    function __construct($IQR_article) {
    }

    public static function create($id, $title, $input_message_content, $url = "", $hide_url = false, $description = "", $thumb_url = "", $thumb_width = "", $thumb_height = "", $reply_markup = []) {
        /*
            $id: `str` 1-64 bytes
            $title: `str`
            $input_message_content: :method:`InputTextMessageContent.create()` OR
                                            `InputLocationMessageContent.create()` OR
                                            `InputVenueMessageContent.create()` OR
                                            `InputContactMessageContent.create()`
            $url: Optional[`str`]
            $hide_url: Optional[`bool`] Default: false
            $description: Optional[`str`]
            $thumb_url: Optional[`str`]
            $thumb_width: Optional[`int`]
            $thumb_height: Optional[`int`]
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()`]
        */

        $IQR_article = [
            "type" => "article",
            "id" => $id,
            "title" => $title,
            "input_message_content" => $input_message_content
        ];
        if ($url) $IQR_article["url"] = $url;
        if ($hide_url) $IQR_article["hide_url"] = $hide_url;
        if ($description) $IQR_article["description"] = $description;
        if ($thumb_url) $IQR_article["thumb_url"] = $thumb_url;
        if ($thumb_width) $IQR_article["thumb_width"] = $thumb_width;
        if ($thumb_height) $IQR_article["thumb_height"] = $thumb_height;
        if ($reply_markup) $IQR_article["reply_markup"] = $reply_markup;
        return $IQR_article;
    }
}

class InlineQueryResultPhoto {
    /*
        Represents a link to a photo. By default, this photo will be sent by
        the user with optional caption. Alternatively, you can use
        input_message_content to send a message with the specified content
        instead of the photo.
    */

    function __construct($IQR_photo) {
    }

    public static function create($id, $photo_url, $thumb_url, $photo_width = "", $photo_height = "", $title = "", $description = "", $caption = "", $parse_mode = "", $caption_entities = [], $reply_markup = [], $input_message_content = []) {
        /*
            $id: `str` 1-64 bytes
            $photo_url: `str`
            $thumb_url: `str`
            $photo_width: Optional[`int`]
            $photo_height: Optional[`int`]
            $title: Optional[`str`]
            $description: Optional[`str`]
            $caption: Optional[`str`] 0-1024 characters
            $parse_mode: Optional[`str`[Markdown | MarkdownV2 | HTML]]
            $caption_entities: Optional[`array`[*:method:`MessageEntity.create()`]]
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()`]
            $input_message_content: Optional[:method:`InputTextMessageContent.create()` OR
                                                     `InputLocationMessageContent.create()` OR
                                                     `InputVenueMessageContent.create()` OR
                                                     `InputContactMessageContent.create()`]
        */

        $IQR_photo = [
            "type" => "photo",
            "id" => $id,
            "photo_url" => $photo_url,
            "thumb_url" => $thumb_url
        ];
        if ($photo_width) $IQR_photo["photo_width"] = $photo_width;
        if ($photo_height) $IQR_photo["photo_height"] = $photo_height;
        if ($title) $IQR_photo["title"] = $title;
        if ($description) $IQR_photo["description"] = $description;
        if ($caption) $IQR_photo["caption"] = $caption;
        if ($parse_mode) $IQR_photo["parse_mode"] = $parse_mode;
        if ($caption_entities) $IQR_photo["caption_entities"] = $caption_entities;
        if ($reply_markup) $IQR_photo["reply_markup"] = $reply_markup;
        if ($input_message_content) $IQR_photo["input_message_content"] = $input_message_content;
        return $IQR_photo;
    }
}

class InlineQueryResultGif {
    /*
        Represents a link to an animated GIF file. By default, this animated GIF
        file will be sent by the user with optional caption. Alternatively, you
        can use input_message_content to send a message with the specified
        content instead of the animation.
    */

    function __construct($IQR_gif) {
    }

    public static function create($id, $gif_url, $thumb_url, $gif_width = "", $gif_height = "", $gif_duration = "", $thumb_mime_type = "", $title = "", $caption = "", $parse_mode = "", $caption_entities = [], $reply_markup = [], $input_message_content = []) {
        /*
            $id: `str` 1-64 bytes
            $gif_url: `str`
            $thumb_url: `str`
            $gif_width: Optional[`int`]
            $gif_height: Optional[`int`]
            $gif_duration: Optional[`int`]
            $thumb_mime_type: Optional[`str`]
            $title: Optional[`str`]
            $caption: Optional[`str`] 0-1024 characters
            $parse_mode: Optional[`str`[Markdown | MarkdownV2 | HTML]]
            $caption_entities: Optional[`array`[*:method:`MessageEntity.create()`]]
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()`]
            $input_message_content: Optional[:method:`InputTextMessageContent.create()` OR
                                                     `InputLocationMessageContent.create()` OR
                                                     `InputVenueMessageContent.create()` OR
                                                     `InputContactMessageContent.create()`]
        */

        $IQR_gif = [
            "type" => "gif",
            "id" => $id,
            "gif_url" => $gif_url,
            "thumb_url" => $thumb_url
        ];
        if ($gif_width) $IQR_gif["gif_width"] = $gif_width;
        if ($gif_height) $IQR_gif["gif_height"] = $gif_height;
        if ($gif_duration) $IQR_gif["gif_duration"] = $gif_duration;
        if ($thumb_mime_type) $IQR_gif["thumb_mime_type"] = $thumb_mime_type;
        if ($title) $IQR_gif["title"] = $title;
        if ($caption) $IQR_gif["caption"] = $caption;
        if ($parse_mode) $IQR_gif["parse_mode"] = $parse_mode;
        if ($caption_entities) $IQR_gif["caption_entities"] = $caption_entities;
        if ($reply_markup) $IQR_gif["reply_markup"] = $reply_markup;
        if ($input_message_content) $IQR_gif["input_message_content"] = $input_message_content;
        return $IQR_gif;
    }
}

class InlineQueryResultMpeg4Gif {
    /*
        Represents a link to a video animation (H.264/MPEG-4 AVC video without
        sound). By default, this animated MPEG-4 file will be sent by the user
        with optional caption. Alternatively, you can use input_message_content
        to send a message with the specified content instead of the animation.
    */

    function __construct($IQR_mpeg4_gif) {
    }

    public static function create($id, $mpeg4_url, $thumb_url, $mpeg4_width = "", $mpeg4_height = "", $mpeg4_duration = "", $thumb_mime_type = "", $title = "", $caption = "", $parse_mode = "", $caption_entities = [], $reply_markup = [], $input_message_content = []) {
        /*
            $id: `str` 1-64 bytes
            $mpeg4_url: `str`
            $thumb_url: `str`
            $mpeg4_width: Optional[`int`]
            $mpeg4_height: Optional[`int`]
            $mpeg4_duration: Optional[`int`]
            $thumb_mime_type: Optional[`str`]
            $title: Optional[`str`]
            $caption: Optional[`str`] 0-1024 characters
            $parse_mode: Optional[`str`[Markdown | MarkdownV2 | HTML]]
            $caption_entities: Optional[`array`[*:method:`MessageEntity.create()`]]
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()`]
            $input_message_content: Optional[:method:`InputTextMessageContent.create()` OR
                                                     `InputLocationMessageContent.create()` OR
                                                     `InputVenueMessageContent.create()` OR
                                                     `InputContactMessageContent.create()`]
        */

        $IQR_mpeg4_gif = [
            "type" => "mpeg4_gif",
            "id" => $id,
            "mpeg4_url" => $mpeg4_url,
            "thumb_url" => $thumb_url
        ];
        if ($mpeg4_width) $IQR_mpeg4_gif["mpeg4_width"] = $mpeg4_width;
        if ($mpeg4_height) $IQR_mpeg4_gif["mpeg4_height"] = $mpeg4_height;
        if ($mpeg4_duration) $IQR_mpeg4_gif["mpeg4_duration"] = $mpeg4_duration;
        if ($thumb_mime_type) $IQR_mpeg4_gif["thumb_mime_type"] = $thumb_mime_type;
        if ($title) $IQR_mpeg4_gif["title"] = $title;
        if ($caption) $IQR_mpeg4_gif["caption"] = $caption;
        if ($parse_mode) $IQR_mpeg4_gif["parse_mode"] = $parse_mode;
        if ($caption_entities) $IQR_mpeg4_gif["caption_entities"] = $caption_entities;
        if ($reply_markup) $IQR_mpeg4_gif["reply_markup"] = $reply_markup;
        if ($input_message_content) $IQR_mpeg4_gif["input_message_content"] = $input_message_content;
        return $IQR_mpeg4_gif;
    }
}

class InlineQueryResultVideo {
    /*
        Represents a link to a page containing an embedded video player or a
        video file. By default, this video file will be sent by the user with
        an optional caption. Alternatively, you can use input_message_content
        to send a message with the specified content instead of the video.

        If an InlineQueryResultVideo message contains an embedded video(e.g.,
        YouTube), you must replace its content using input_message_content.
    */

    function __construct($IQR_video) {
    }

    public static function create($id, $video_url, $mime_type, $thumb_url, $title, $video_width = "", $video_height = "", $video_duration = "", $description = "", $caption = "", $parse_mode = "", $caption_entities = [], $reply_markup = [], $input_message_content = []) {
        /*
            $id: `str` 1-64 bytes
            $video_url: `str`
            $mime_type: `str`
            $thumb_url: `str`
            $title: `str`
            $video_width: Optional[`int`]
            $video_height: Optional[`int`]
            $video_duration: Optional[`int`]
            $description: Optional[`str`]
            $caption: Optional[`str`] 0-1024 characters
            $parse_mode: Optional[`str`[Markdown | MarkdownV2 | HTML]]
            $caption_entities: Optional[`array`[*:method:`MessageEntity.create()`]]
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()`]
            $input_message_content: Optional[:method:`InputTextMessageContent.create()` OR
                                                     `InputLocationMessageContent.create()` OR
                                                     `InputVenueMessageContent.create()` OR
                                                     `InputContactMessageContent.create()`]
        */

        $IQR_video = [
            "type" => "video",
            "id" => $id,
            "video_url" => $video_url,
            "mime_type" => $mime_type,
            "thumb_url" => $thumb_url,
            "title" => $title
        ];
        if ($video_width) $IQR_video["video_width"] = $video_width;
        if ($video_height) $IQR_video["video_height"] = $video_height;
        if ($video_duration) $IQR_video["video_duration"] = $video_duration;
        if ($description) $IQR_video["description"] = $description;
        if ($caption) $IQR_video["caption"] = $caption;
        if ($parse_mode) $IQR_video["parse_mode"] = $parse_mode;
        if ($caption_entities) $IQR_video["caption_entities"] = $caption_entities;
        if ($reply_markup) $IQR_video["reply_markup"] = $reply_markup;
        if ($input_message_content) $IQR_video["input_message_content"] = $input_message_content;
        return $IQR_video;
    }
}

class InlineQueryResultAudio {
    /*
        Represents a link to an MP3 audio file. By default, this audio file will
        be sent by the user. Alternatively, you can use input_message_content to
        send a message with the specified content instead of the audio.
    */

    function __construct($IQR_audio) {
    }

    public static function create($id, $audio_url, $title, $performer = "", $audio_duration = "", $caption = "", $parse_mode = "", $caption_entities = [], $reply_markup = [], $input_message_content = []) {
        /*
            $id: `str` 1-64 bytes
            $audio_url: `str`
            $title: `str`
            $performer: Optional[`str`]
            $audio_duration: Optional[`int`]
            $caption: Optional[`str`] 0-1024 characters
            $parse_mode: Optional[`str`[Markdown | MarkdownV2 | HTML]]
            $caption_entities: Optional[`array`[*:method:`MessageEntity.create()`]]
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()`]
            $input_message_content: Optional[:method:`InputTextMessageContent.create()` OR
                                                     `InputLocationMessageContent.create()` OR
                                                     `InputVenueMessageContent.create()` OR
                                                     `InputContactMessageContent.create()`]
        */

        $IQR_audio = [
            "type" => "audio",
            "id" => $id,
            "audio_url" => $audio_url,
            "title" => $title
        ];
        if ($performer) $IQR_audio["performer"] = $performer;
        if ($audio_duration) $IQR_audio["audio_duration"] = $audio_duration;
        if ($caption) $IQR_audio["caption"] = $caption;
        if ($parse_mode) $IQR_audio["parse_mode"] = $parse_mode;
        if ($caption_entities) $IQR_audio["caption_entities"] = $caption_entities;
        if ($reply_markup) $IQR_audio["reply_markup"] = $reply_markup;
        if ($input_message_content) $IQR_audio["input_message_content"] = $input_message_content;
        return $IQR_audio;
    }
}

class InlineQueryResultVoice {
    /*
        Represents a link to a voice recording in an .OGG container encoded with
        OPUS. By default, this voice recording will be sent by the user.
        Alternatively, you can use input_message_content to send a message with
        the specified content instead of the the voice message.
    */

    function __construct($IQR_voice) {
    }

    public static function create($id, $voice_url, $title, $voice_duration = "", $caption = "", $parse_mode = "", $caption_entities = [], $reply_markup = [], $input_message_content = []) {
        /*
            $id: `str` 1-64 bytes
            $voice_url: `str`
            $title: `str`
            $voice_duration: Optional[`int`]
            $caption: Optional[`str`] 0-1024 characters
            $parse_mode: Optional[`str`[Markdown | MarkdownV2 | HTML]]
            $caption_entities: Optional[`array`[*:method:`MessageEntity.create()`]]
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()`]
            $input_message_content: Optional[:method:`InputTextMessageContent.create()` OR
                                                     `InputLocationMessageContent.create()` OR
                                                     `InputVenueMessageContent.create()` OR
                                                     `InputContactMessageContent.create()`]
        */

        $IQR_voice = [
            "type" => "voice",
            "id" => $id,
            "voice_url" => $voice_url,
            "title" => $title
        ];
        if ($voice_duration) $IQR_voice["voice_duration"] = $voice_duration;
        if ($caption) $IQR_voice["caption"] = $caption;
        if ($parse_mode) $IQR_voice["parse_mode"] = $parse_mode;
        if ($caption_entities) $IQR_voice["caption_entities"] = $caption_entities;
        if ($reply_markup) $IQR_voice["reply_markup"] = $reply_markup;
        if ($input_message_content) $IQR_voice["input_message_content"] = $input_message_content;
        return $IQR_voice;
    }
}

class InlineQueryResultDocument {
    /*
        Represents a link to a file. By default, this file will be sent by the
        user with an optional caption. Alternatively, you can use
        input_message_content to send a message with the specified content
        instead of the file. Currently, only .PDF and .ZIP files can be sent
        using this method.
    */

    function __construct($IQR_document) {
    }

    public static function create($id, $document_url, $mime_type, $title, $description = "", $thumb_url = "", $thumb_width = "", $thumb_height = "", $caption = "", $parse_mode = "", $caption_entities = [], $reply_markup = [], $input_message_content = []) {
        /*
            $id: `str` 1-64 bytes
            $document_url: `str`
            $mime_type: `str`
            $title: `str`
            $description: Optional[`str`]
            $thumb_url: Optional[`str`]
            $thumb_width: Optional[`int`]
            $thumb_height: Optional[`int`]
            $caption: Optional[`str`] 0-1024 characters
            $parse_mode: Optional[`str`[Markdown | MarkdownV2 | HTML]]
            $caption_entities: Optional[`array`[*:method:`MessageEntity.create()`]]
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()`]
            $input_message_content: Optional[:method:`InputTextMessageContent.create()` OR
                                                     `InputLocationMessageContent.create()` OR
                                                     `InputVenueMessageContent.create()` OR
                                                     `InputContactMessageContent.create()`]
        */

        $IQR_document = [
            "type" => "document",
            "id" => $id,
            "document_url" => $document_url,
            "mime_type" => $mime_type,
            "title" => $title
        ];
        if ($description) $IQR_document["description"] = $description;
        if ($thumb_url) $IQR_document["thumb_url"] = $thumb_url;
        if ($thumb_width) $IQR_document["thumb_width"] = $thumb_width;
        if ($thumb_height) $IQR_document["thumb_height"] = $thumb_height;
        if ($caption) $IQR_document["caption"] = $caption;
        if ($parse_mode) $IQR_document["parse_mode"] = $parse_mode;
        if ($caption_entities) $IQR_document["caption_entities"] = $caption_entities;
        if ($reply_markup) $IQR_document["reply_markup"] = $reply_markup;
        if ($input_message_content) $IQR_document["input_message_content"] = $input_message_content;
        return $IQR_document;
    }
}

class InlineQueryResultLocation {
    /*
        Represents a location on a map. By default, the location will be sent
        by the user. Alternatively, you can use input_message_content to send
        a message with the specified content instead of the location.
    */

    function __construct($IQR_location) {
    }

    public static function create($id, $latitude, $longitude, $title, $horizontal_accuracy = "", $live_period = "", $heading = "", $proximity_alert_radius = "", $thumb_url = "", $thumb_width = "", $thumb_height = "", $reply_markup = [], $input_message_content = []) {
        /*
            $id: `str` 1-64 bytes
            $latitude: `float`
            $longitude: `float`
            $title: `str`
            $horizontal_accuracy: Optional[`float`] Range: 0 to 1500
            $live_period: Optional[`int`] Range: 60 to 86400
            $heading: Optional[`int`] Range: 1 to 360
            $proximity_alert_radius: Optional[`int`] Range: 1 to 100000
            $thumb_url: Optional[`str`]
            $thumb_width: Optional[`int`]
            $thumb_height: Optional[`int`]
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()`]
            $input_message_content: Optional[:method:`InputTextMessageContent.create()` OR
                                                     `InputLocationMessageContent.create()` OR
                                                     `InputVenueMessageContent.create()` OR
                                                     `InputContactMessageContent.create()`]
        */

        $IQR_location = [
            "type" => "location",
            "id" => $id,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "title" => $title
        ];
        if ($horizontal_accuracy) $IQR_location["horizontal_accuracy"] = $horizontal_accuracy;
        if ($live_period) $IQR_location["live_period"] = $live_period;
        if ($heading) $IQR_location["heading"] = $heading;
        if ($proximity_alert_radius) $IQR_location["proximity_alert_radius"] = $proximity_alert_radius;
        if ($thumb_url) $IQR_location["thumb_url"] = $thumb_url;
        if ($thumb_width) $IQR_location["thumb_width"] = $thumb_width;
        if ($thumb_height) $IQR_location["thumb_height"] = $thumb_height;
        if ($reply_markup) $IQR_location["reply_markup"] = $reply_markup;
        if ($input_message_content) $IQR_location["input_message_content"] = $input_message_content;
        return $IQR_location;
    }
}

class InlineQueryResultVenue {
    /*
        Represents a venue. By default, the venue will be sent by the user.
        Alternatively, you can use input_message_content to send a message with
        the specified content instead of the venue.
    */

    function __construct($IQR_venue) {
    }

    public static function create($id, $latitude, $longitude, $title, $address, $foursquare_id = "", $foursquare_type = "", $google_place_id = "", $google_place_type = "", $thumb_url = "", $thumb_width = "", $thumb_height = "", $reply_markup = [], $input_message_content = []) {
        /*
            $id: `str` 1-64 bytes
            $latitude: `float`
            $longitude: `float`
            $title: `str`
            $address: `str`
            $foursquare_id: Optional[`str`]
            $foursquare_type: Optional[`str`]
            $google_place_id: Optional[`str`]
            $google_place_type: Optional[`str`]
            $thumb_url: Optional[`str`]
            $thumb_width: Optional[`int`]
            $thumb_height: Optional[`int`]
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()`]
            $input_message_content: Optional[:method:`InputTextMessageContent.create()` OR
                                                     `InputLocationMessageContent.create()` OR
                                                     `InputVenueMessageContent.create()` OR
                                                     `InputContactMessageContent.create()`]
        */

        $IQR_venue = [
            "type" => "venue",
            "id" => $id,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "title" => $title,
            "address" => $address
        ];
        if ($foursquare_id) $IQR_venue["foursquare_id"] = $foursquare_id;
        if ($foursquare_type) $IQR_venue["foursquare_type"] = $foursquare_type;
        if ($google_place_id) $IQR_venue["google_place_id"] = $google_place_id;
        if ($google_place_type) $IQR_venue["google_place_type"] = $google_place_type;
        if ($thumb_url) $IQR_venue["thumb_url"] = $thumb_url;
        if ($thumb_width) $IQR_venue["thumb_width"] = $thumb_width;
        if ($thumb_height) $IQR_venue["thumb_height"] = $thumb_height;
        if ($reply_markup) $IQR_venue["reply_markup"] = $reply_markup;
        if ($input_message_content) $IQR_venue["input_message_content"] = $input_message_content;
        return $IQR_venue;
    }
}

class InlineQueryResultContact {
    /*
        Represents a contact with a phone number. By default, this contact will
        be sent by the user. Alternatively, you can use input_message_content
        to send a message with the specified content instead of the contact.
    */

    function __construct($IQR_contact) {
    }

    public static function create($id, $phone_number, $first_name, $last_name = "", $vcard = "", $thumb_url = "", $thumb_width = "", $thumb_height = "", $reply_markup = [], $input_message_content = []) {
        /*
            $id: `str` 1-64 bytes
            $phone_number: `str`
            $first_name: `str`
            $last_name: Optional[`str`]
            $vcard: Optional[`str`]
            $thumb_url: Optional[`str`]
            $thumb_width: Optional[`int`]
            $thumb_height: Optional[`int`]
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()`]
            $input_message_content: Optional[:method:`InputTextMessageContent.create()` OR
                                                     `InputLocationMessageContent.create()` OR
                                                     `InputVenueMessageContent.create()` OR
                                                     `InputContactMessageContent.create()`]
        */

        $IQR_contact = [
            "type" => "contact",
            "id" => $id,
            "phone_number" => $phone_number,
            "first_name" => $first_name
        ];
        if ($last_name) $IQR_contact["last_name"] = $last_name;
        if ($vcard) $IQR_contact["vcard"] = $vcard;
        if ($thumb_url) $IQR_contact["thumb_url"] = $thumb_url;
        if ($thumb_width) $IQR_contact["thumb_width"] = $thumb_width;
        if ($thumb_height) $IQR_contact["thumb_height"] = $thumb_height;
        if ($reply_markup) $IQR_contact["reply_markup"] = $reply_markup;
        if ($input_message_content) $IQR_contact["input_message_content"] = $input_message_content;
        return $IQR_contact;
    }
}

class InlineQueryResultGame {
    /*
        Represents a Game.
    */

    function __construct($IQR_game) {
    }

    public static function create($id, $game_short_name, $reply_markup = []) {
        /*
            $id: `str` 1-64 bytes
            $game_short_name: `str`
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()`]
        */

        $IQR_game = [
            "type" => "game",
            "id" => $id,
            "game_short_name" => $game_short_name
        ];
        if ($reply_markup) $IQR_game["reply_markup"] = $reply_markup;
        return $IQR_game;
    }
}

class InlineQueryResultCachedMedia {
    /*
        Represents a link to a media stored on the Telegram servers. By default,
        this media will be sent by the user with an optional caption.
        Alternatively, you can use input_message_content to send a message with
        the specified content instead of the media.
    */

    function __construct($IQR_cached_media) {
    }

    public static function create($type, $id, $file_id, $title = "", $description = "", $caption = "", $parse_mode = "", $caption_entities = [], $reply_markup = [], $input_message_content = []) {
        /*
            $type: `str`[photo | gif | mpeg4_gif | document | video | voice | audio]
            $id: `str` 1-64 bytes
            $file_id: `str`
            $title: Optional[`str`] Note: Not required for $type audio.
            $description: Optional[`str`] Note: Not required for $type gif, mpeg4_gif, voice and audio.
            $caption: Optional[`str`] 0-1024 characters
            $parse_mode: Optional[`str`[Markdown | MarkdownV2 | HTML]]
            $caption_entities: Optional[`array`[*:method:`MessageEntity.create()`]]
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()`]
            $input_message_content: Optional[:method:`InputTextMessageContent.create()` OR
                                                     `InputLocationMessageContent.create()` OR
                                                     `InputVenueMessageContent.create()` OR
                                                     `InputContactMessageContent.create()`]
        */

        $IQR_cached_media = [
            "type" => $type,
            "id" => $id
        ];
        if ($type === "mpeg4_gif") $type = "mpeg";
        $IQR_cached_media[$type . "_file_id"] = $file_id;
        if ($title) $IQR_cached_media["title"] = $title;
        if ($description) $IQR_cached_media["description"] = $description;
        if ($caption) $IQR_cached_media["caption"] = $caption;
        if ($parse_mode) $IQR_cached_media["parse_mode"] = $parse_mode;
        if ($caption_entities) $IQR_cached_media["caption_entities"] = $caption_entities;
        if ($reply_markup) $IQR_cached_media["reply_markup"] = $reply_markup;
        if ($input_message_content) $IQR_cached_media["input_message_content"] = $input_message_content;
        return $IQR_cached_media;
    }
}

class InlineQueryResultCachedSticker {
    /*
        Represents a link to a sticker stored on the Telegram servers. By
        default, this sticker will be sent by the user. Alternatively, you can
        use input_message_content to send a message with the specified content
        instead of the sticker.
    */

    function __construct($IQR_cached_sticker) {
    }

    public static function create($id, $sticker_file_id, $reply_markup = [], $input_message_content = []) {
        /*
            $id: `str` 1-64 bytes
            $sticker_file_id: `str`
            $reply_markup: Optional[:method:`InlineKeyboardMarkup.create()`]
            $input_message_content: Optional[:method:`InputTextMessageContent.create()` OR
                                                     `InputLocationMessageContent.create()` OR
                                                     `InputVenueMessageContent.create()` OR
                                                     `InputContactMessageContent.create()`]
        */

        $IQR_cached_sticker = [
            "type" => "sticker",
            "id" => $id,
            "sticker_file_id" => $sticker_file_id
        ];
        if ($reply_markup) $IQR_cached_sticker["reply_markup"] = $reply_markup;
        if ($input_message_content) $IQR_cached_sticker["input_message_content"] = $input_message_content;
        return $IQR_cached_sticker;
    }
}

class InputTextMessageContent {
    /*
        Represents the content of a text message to be sent as the result of an
        inline query.
    */

    function __construct($IMC_text) {
    }

    public static function create($message_text, $parse_mode = "", $entities = [], $no_preview = false) {
        /*
            $message_text: `str` 1-4096 characters
            $parse_mode: Optional[`str`[Markdown | MarkdownV2 | HTML]]
            $entities: Optional[`array`[*:method:`MessageEntity.create()`]]
            $no_preview: Optional[`bool`] Default: false
        */

        $IMC_text = [
            "message_text" => $message_text
        ];
        if ($parse_mode) $IMC_text["parse_mode"] = $parse_mode;
        if ($entities) $IMC_text["entities"] = $entities;
        if ($no_preview) $IMC_text["no_preview"] = $no_preview;
        return $IMC_text;
    }
}

class InputLocationMessageContent {
    /*
        Represents the content of a location message to be sent as the result
        of an inline query.
    */

    function __construct($IMC_location) {
    }

    public static function create($latitude, $longitude, $horizontal_accuracy = "", $live_period = "", $heading = "", $proximity_alert_radius = "") {
        /*
            $latitude: `float`
            $longitude: `float`
            $horizontal_accuracy: Optional[`float`] Range: 0 to 1500
            $live_period: Optional[`int`] Range: 60 to 86400
            $heading: Optional[`int`] Range: 1 to 360
            $proximity_alert_radius: Optional[`int`] Range: 1 to 100000
        */

        $IMC_location = [
            "latitude" => $latitude,
            "longitude" => $longitude
        ];
        if ($horizontal_accuracy) $IMC_location["horizontal_accuracy"] = $horizontal_accuracy;
        if ($live_period) $IMC_location["live_period"] = $live_period;
        if ($heading) $IMC_location["heading"] = $heading;
        if ($proximity_alert_radius) $IMC_location["proximity_alert_radius"] = $proximity_alert_radius;
        return $IMC_location;
    }
}

class InputVenueMessageContent {
    /*
        Represents the content of a venue message to be sent as the result of
        an inline query.
    */

    function __construct($IMC_venue) {
    }

    public static function create($latitude, $longitude, $title, $address, $foursquare_id = "", $foursquare_type = "", $google_place_id = "", $google_place_type = "") {
        /*
            $latitude: `float`
            $longitude: `float`
            $title: `str`
            $address: `str`
            $foursquare_id: Optional[`str`]
            $foursquare_type: Optional[`str`]
            $google_place_id: Optional[`str`]
            $google_place_type: Optional[`str`]
        */

        $IMC_venue = [
            "latitude" => $latitude,
            "longitude" => $longitude,
            "title" => $title,
            "address" => $address
        ];
        if ($foursquare_id) $IMC_venue["foursquare_id"] = $foursquare_id;
        if ($foursquare_type) $IMC_venue["foursquare_type"] = $foursquare_type;
        if ($google_place_id) $IMC_venue["google_place_id"] = $google_place_id;
        if ($google_place_type) $IMC_venue["google_place_type"] = $google_place_type;
        return $IMC_venue;
    }
}

class InputContactMessageContent {
    /*
        Represents the content of a contact message to be sent as the result of
        an inline query.
    */

    function __construct($IMC_contact) {
    }

    public static function create($phone_number, $first_name, $last_name = "", $vcard = "") {
        /*
            $phone_number: `str`
            $first_name: `str`
            $last_name: Optional[`str`]
            $vcard: Optional[`str`]
        */

        $IMC_contact = [
            "phone_number" => $phone_number,
            "first_name" => $first_name
        ];
        if ($last_name) $IMC_contact["last_name"] = $last_name;
        if ($vcard) $IMC_contact["vcard"] = $vcard;
        return $IMC_contact;
    }
}

class ChosenInlineResult {
    /*
        Represents a result of an inline query that was chosen by the user and
        sent to their chat partner.
    */

    public $result_id;
    public $from;
    public $query;
    public $location;
    public $inline_message_id;

    function __construct($chosen_inline_result) {
        $this->result_id = $chosen_inline_result["result_id"];
        $this->from = new User($chosen_inline_result["from"]);
        $this->query = $chosen_inline_result["query"];
        $this->location = array_key_exists("location", $chosen_inline_result) ? new Location($chosen_inline_result["location"]) : null;
        $this->inline_message_id = array_key_exists("inline_message_id", $chosen_inline_result) ? $chosen_inline_result["inline_message_id"] : null;
    }
}

class Err {
    /*
        This object represents an error after an unsuccessful request.
    */

    public $ok;
    public $error_code;
    public $description;

    function __construct($error) {
        $this->ok = $error["ok"];
        $this->error_code = $error["error_code"];
        $this->description = $error["description"];
    }
}
?>