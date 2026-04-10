<?php

declare(strict_types=1);

namespace Tests\ThreeBRS\SyliusDocumentationPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Symfony\Component\Filesystem\Filesystem;

final class DocumentationContext implements Context
{
    private string $docsPath;

    public function __construct(string $docsPath)
    {
        $this->docsPath = $docsPath;
    }

    /**
     * @Given there are no documentation files in the documentation directory
     */
    public function thereAreNoDocumentationFilesInTheDocsDirectory(): void
    {
        $this->createDir($this->docsPath);

        $files = glob($this->docsPath . '/*'); // Get all files in the directory
        foreach ($files as $file) {
            if (is_file($file)) {
                $this->deleteFile($file);
            }
        }
    }

    private function deleteFile(string $filePath): void
    {
        (new Filesystem())->remove($filePath);
    }

    private function createDir(string $dir): void
    {
        (new Filesystem())->mkdir($dir, 0755);
    }

    /**
     * @Given there is a :filename documentation file with content:
     */
    public function thereIsADocumentationFileWithContent(
        string $filename,
        string $content,
    ): void {
        $this->createDir($this->docsPath);

        $filePath = $this->docsPath . '/' . $filename;

        $this->createFile($filePath, $content);
    }

    private function createFile(
        string $filePath,
        string $content,
    ): void {
        if (file_put_contents($filePath, trim($content)) === false) {
            throw new \RuntimeException(sprintf('Failed to create documentation file: %s', $filePath));
        }
    }

    /**
     * @Given there is a :filename documentation file
     */
    public function thereIsADocumentationFile(string $filename): void
    {
        $this->createDir($this->docsPath);

        $filePath = $this->docsPath . '/' . $filename;
        $content = '# ' . ucfirst(str_replace(['-', '_'], ' ', pathinfo($filename, \PATHINFO_FILENAME))) . "\n\nThis is a sample documentation page.";

        $this->createFile($filePath, $content);
    }

    /**
     * @Given there is no :filename file
     */
    public function thereIsNoFile(string $filename): void
    {
        $filePath = $this->docsPath . '/' . $filename;
        if (file_exists($filePath)) {
            $this->deleteFile($filePath);
        }
    }

    /**
     * @Given there is a :filename file in the documentation directory
     */
    public function thereIsAFileInTheDocsDirectory(string $filename): void
    {
        $this->createDir($this->docsPath);

        $filePath = $this->docsPath . '/' . $filename;

        // Create a simple image file for testing
        if (pathinfo($filename, \PATHINFO_EXTENSION) === 'png') {
            // Create a 1x1 pixel PNG
            $imageData = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==');
            $this->createFile($filePath, $imageData);
        } else {
            // Create a simple text file
            $this->createFile($filePath, 'Test file content');
        }
    }
}
