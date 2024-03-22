<?php
/**
 * Plugin Name: Mautic Connector
 * Description: Connects WordPress with Mautic.
 * Version: 1.0
 * Author: Your Name
 */

// Hook to run after a user is registered
add_action('user_register', 'send_user_data_to_mautic_get_id');

// Function to send user data to Mautic and get contact ID
function send_user_data_to_mautic_get_id($user_id) {
    // Get user data
    $user = get_userdata($user_id);

    // Check if user data is available
    if ($user) {
        $user_email = $user->user_email;
        $user_name = $user->user_login;

        // Mautic API endpoint for adding a contact
        $mautic_api_url_add_contact = 'https://mautic.scovietnam.com/api/contacts/new'; // Replace with your Mautic instance URL

        // Mautic API credentials
        $mautic_api_username = 'mautic_user_login'; // Replace with your Mautic username
        $mautic_api_password = 'mautic_password_login'; // Replace with your Mautic password

        // Prepare data to send to Mautic
        $data_add_contact = array(
            'email' => $user_email,
            'firstname' => $user_name,
            // Add more data fields as needed
        );

        // Send data to Mautic using Basic Authentication
        $response_add_contact = wp_remote_post($mautic_api_url_add_contact, array(
            'body' => json_encode($data_add_contact),
            'headers' => array(
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode("$mautic_api_username:$mautic_api_password"),
            ),
        ));

        // Log the Mautic API response for adding a contact
        if (is_wp_error($response_add_contact)) {
            $error_message_add_contact = $response_add_contact->get_error_message();
            error_log('Mautic API request (add contact) failed: ' . $error_message_add_contact);
        } else {
            $body_add_contact = wp_remote_retrieve_body($response_add_contact);
            $decoded_response_add_contact = json_decode($body_add_contact, true);
            error_log('Mautic API Response (add contact): ' . print_r($decoded_response_add_contact, true));

            // Check if the contact was successfully added
            if (isset($decoded_response_add_contact['contact']['id'])) {
                $mautic_contact_id = $decoded_response_add_contact['contact']['id'];
                error_log('Mautic Contact ID: ' . $mautic_contact_id);

                // Update the WordPress user with the Mautic contact ID
                update_user_meta($user_id, 'mautic_contact_id', $mautic_contact_id);

                // Add the newly registered user to the Mautic segment
                add_user_to_mautic_segment($mautic_contact_id, '3'); // Replace '1' with your segment ID
            } else {
                error_log('Mautic API Response does not contain contact ID.');
            }
        }
        // Log the Mautic API response for adding a contact
            if (is_wp_error($response_add_contact)) {
                $error_message_add_contact = $response_add_contact->get_error_message();
                error_log('Mautic API request (add contact) failed: ' . $error_message_add_contact);
            } else {
                $body_add_contact = wp_remote_retrieve_body($response_add_contact);
                $decoded_response_add_contact = json_decode($body_add_contact, true);
                error_log('Mautic API Response (add contact): ' . print_r($decoded_response_add_contact, true));

                // Check if the contact was successfully added
                if (isset($decoded_response_add_contact['contact']['id'])) {
                    $mautic_contact_id = $decoded_response_add_contact['contact']['id'];
                    error_log('Mautic Contact ID: ' . $mautic_contact_id);

                    // Update the WordPress user with the Mautic contact ID
                    update_user_meta($user_id, 'mautic_contact_id', $mautic_contact_id);

                    // Add the newly registered user to the Mautic segment
                    add_user_to_mautic_segment($mautic_contact_id, '3'); // Replace '1' with your segment ID
                } else {
                    // Log additional details about the response
                    error_log('Mautic API Response (add contact) does not contain contact ID. Full response: ' . print_r($decoded_response_add_contact, true));
                }
            }
    }
}

// Function to add a user to a Mautic segment
function add_user_to_mautic_segment($contact_id, $segment_id) {
    // Mautic API endpoint for adding a contact to a segment
    $mautic_api_url_add_to_segment = "https://mautic.scovietnam.com/api/segments/{$segment_id}/contact/{$contact_id}/add"; // Replace with your Mautic instance URL

    // Mautic API credentials
    $mautic_api_username = 'mautic_user_login'; // Replace with your Mautic username
    $mautic_api_password = 'mautic_password_login'; // Replace with your Mautic password

    // Send request to add contact to segment
    $response_add_to_segment = wp_remote_post($mautic_api_url_add_to_segment, array(
        'headers' => array(
            'Authorization' => 'Basic ' . base64_encode("$mautic_api_username:$mautic_api_password"),
        ),
    ));

    // Log the Mautic API response for adding to segment
    if (is_wp_error($response_add_to_segment)) {
        $error_message_add_to_segment = $response_add_to_segment->get_error_message();
        error_log('Mautic API request (add to segment) failed: ' . $error_message_add_to_segment);
    } else {
        $body_add_to_segment = wp_remote_retrieve_body($response_add_to_segment);
        $decoded_response_add_to_segment = json_decode($body_add_to_segment, true);
        error_log('Mautic API Response (add to segment): ' . print_r($decoded_response_add_to_segment, true));
    }
}
