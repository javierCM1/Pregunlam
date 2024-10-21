<?php

class ProfilePicHandler
{
    public function handleProfilePic()
    {
        $uploadDirectory = 'public/images/fotoDePerfil/';
        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }

        if (isset($_FILES['profile_pic'])
            && $_FILES['profile_pic']['error'] == 0
            && (mime_content_type($_FILES['profile_pic']['tmp_name']) === 'image/png'
                || mime_content_type($_FILES['profile_pic']['tmp_name']) === 'image/jpeg')) {

            $profilePic = $uploadDirectory . basename($_FILES['profile_pic']['name']);
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profilePic)) {
                return $profilePic;
            }
        }
        return '';
    }
}