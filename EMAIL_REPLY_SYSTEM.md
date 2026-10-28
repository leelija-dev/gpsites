# Email Reply System - Complete Conversation Storage

## Database Schema

### Tables:
1. **user_mail_history** - Main thread/conversation record
   - id, user_id, site_url, subject, message, reply_token, blog_email, blog_id, status
   - One conversation per initial email sent

2. **mail_messages** - Individual messages in the conversation
   - id, user_mail_history_id, direction, from_email, from_name, to_emails, cc_emails,
     subject, body_html, body_text, message_id, status, sent_at
   - Multiple messages per conversation (initial, blog_reply, user_reply)

## Storage Flow

### 1. Initial Email (User sends to Blog Owner)
- **Direction:** `initial`
- **From:** `lakshman.leelija@gmail.com` (your app's email)
- **To:** Blog owner's email
- **BCC:** User + Admin
- **Reply-To:** `lakshman+token@gmail.com`
- **Email body includes:** Reference ID: token
- **Database:** Stored in `mail_messages` with `direction='initial'`

### 2. Blog Owner Reply
- **Direction:** `blog_reply`
- **From:** Blog owner's email
- **To:** User's email
- **CC:** Admin
- **Database:** Stored in `mail_messages` with `direction='blog_reply'`
- **Forwarded to:** User with Reply-To: `lakshman+token@gmail.com`
- **Forwarded email includes:** Reference ID: token

### 3. User Reply
- **Direction:** `user_reply`
- **From:** User's email
- **To:** Blog owner's email
- **CC:** Admin
- **Database:** Stored in `mail_messages` with `direction='user_reply'`
- **Forwarded to:** Blog owner with Reply-To: `lakshman+token@gmail.com`
- **Forwarded email includes:** Reference ID: token

## All Messages Stored

✅ **Initial email** - Stored when sent from app
✅ **Blog owner reply** - Stored when processed by mail:forward-replies
✅ **User reply** - Stored when processed by mail:forward-replies
✅ **Subsequent replies** - All stored alternately as blog_reply/user_reply

## Viewing Conversations

To view complete conversation:
```php
$thread = UserMailHistory::with('messages')->find($threadId);
foreach ($thread->messages as $message) {
    echo $message->direction . ': ' . $message->from_email . "\n";
    echo $message->body_html . "\n\n";
}
```

## Direction Values

- `initial` - First email sent from app
- `blog_reply` - Reply from blog owner
- `user_reply` - Reply from user

## Status Values

- `sent` - Email was sent successfully
- `received` - Email was received and stored
- `forwarded` - Email was forwarded to the other party
- `failed` - Email forwarding failed

## Cron Job

The command runs every 5 minutes to process incoming replies:
```bash
php artisan schedule:run
```

Or manually:
```bash
php artisan mail:forward-replies
```
