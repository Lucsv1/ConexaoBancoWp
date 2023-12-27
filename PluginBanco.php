<?php

add_action('elementor_pro/forms/new_record', function ($record, $ajax_handler) {

    $form_name = $record->get_form_settings('form_name');

    if ('Pessoa Juridica' !== $form_name) {
        return;
    }

    $raw_fields = $record->get('fields');
    $fields = [];
    foreach ($raw_fields as $id => $field) {
        $fields[$id] = $field['value'];
    }

    global $wpdb;
    $cnpj = $fields['cnpj'];

    $existing = $wpdb->get_row("SELECT * FROM wp_e_form_pj WHERE cnpj = '$cnpj'");

    if (null !== $existing) {

        $ajax_handler->add_error_message("O CNPJ já existe.");
        return;
    }


    $output['success'] = $wpdb->insert(
        'wp_e_form_pj',
        array(
            'cnpj' => $cnpj,
            'company_name' => $fields['nome'],
            'email' => $fields['email'],
            'telephone' => $fields['telefone'],
            'activity' => $fields['atividade'],
            'name_representative' => $fields['nomeRepresentante'],
            'cpf' => $fields['cpf_representante'],
            'email_representative' => $fields['email_representante'],
            'telephone_representative' => $fields['telefone_representante'],
            'cep' => $fields['cep'],
            'street' => $fields['rua'],
            'neighborhood' => $fields['bairro'],
            'city' => $fields['cidade'],
            'state' => $fields['uf'],
            'NUMBER' => $fields['numero'],
            'complement' => $fields['complemento'],
            'service' => $fields['empresas'],
        ));

    $ajax_handler->add_response_data(true, $output);

}, 10, 2);


