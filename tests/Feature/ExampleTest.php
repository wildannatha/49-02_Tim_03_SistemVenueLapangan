<?php

test('halaman utama mengarahkan tamu ke login', function () {
    $this->get('/')->assertRedirect('/login');
});
