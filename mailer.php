<?php


// Add unique name for files
$emailFileName = 'email' . (string)(date("Ymdhis")) . (string)($_FILES['email']['name']);
$templateFileName = 'template' . (string)(date("Ymdhis")) . (string)($_FILES['template']['name']);

// Upload files.
$uploadEmail = 'uploads/email/' . basename($emailFileName);
$uploadTemplate = 'uploads/template/' . basename($templateFileName);

// TODO::Tasks
// Use Silex micro-framework
// Add admin panel, auth, API
// Add progress bar to all process Service


// API functionality
// Add API method: dump all emails.
// Add API method: dump all templates.
// Add API method: dump all with descriptions: templates, emails

// Verify the files
$tmpEmail = pathinfo($_FILES["email"]["name"], PATHINFO_EXTENSION);
$tmpTemplate = pathinfo($_FILES["template"]["name"], PATHINFO_EXTENSION);

$formatEmail = ['txt'];
$formatTemplate = ['html'];

// Valid by format
if (in_array($tmpEmail, $formatEmail) && in_array($tmpTemplate, $formatTemplate)) {
	// Valid by status upload
	if (move_uploaded_file($_FILES['email']['tmp_name'], $uploadEmail) && move_uploaded_file($_FILES['template']['tmp_name'], $uploadTemplate)) {
		echo '[status]All files is uploaded!';

		// Array with emails
		$contentEmail = explode("\n", file_get_contents($uploadEmail));

		// Html template
		$contentTemplate = file_get_contents($uploadTemplate);

		// Header message
		$subject = "Our header message";

		// Headers settings
		$headers = "Content-type: text/html; charset=windows-1251 \r\n";
		$headers .= "From: Your name\r\n";
		$headers .= "Bcc: Email\r\n";

		// Send mails
		foreach ($contentEmail as $email) {
			// Send mail
			mail($email, $subject, $contentTemplate, $headers);
		}

		header('Location: /');
	} else {
		echo '[status]Files in can\'t uploading! ';
	};
} else {
	echo '[status]File type error, Email = ".txt", Template = ".html"';
}
