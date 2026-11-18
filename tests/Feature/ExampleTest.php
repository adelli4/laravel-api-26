<?php

test('the root route redirects to the product list', function () {
    $this->get('/')
        ->assertRedirect(route('produk.index'));
});
