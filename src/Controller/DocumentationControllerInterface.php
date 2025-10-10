<?php

declare(strict_types=1);

namespace ThreeBRS\SyliusDocumentationPlugin\Controller;

use Symfony\Component\HttpFoundation\Response;

interface DocumentationControllerInterface
{
    public function index(): Response;

    public function show(string $slug = 'index'): Response;

    public function image(string $filename): Response;
}
