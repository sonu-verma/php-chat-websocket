//to see last query
$stmt->debugDumpParams()


User Table:
userId
username
email
password
profileImg
sessionId
connectionId

Message Table:
messageID
message
sentBy
sentTo
created_at
type enum('message','image')
image
status enum('notseen','seen')


ALTER TABLE `users` CHANGE `created_at` `created_at` TIMESTAMP on update CURRENT_TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP;