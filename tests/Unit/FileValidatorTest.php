<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Helpers\FileValidator;

class FileValidatorTest extends TestCase
{
    /**
     * Test filename sanitization
     */
    public function test_filename_sanitization()
    {
        $unsafeFilename = "test@#\$%file<script>.jpg";
        $sanitized = FileValidator::sanitizeFilename($unsafeFilename);

        // Should remove dangerous characters
        $this->assertStringNotContainsString('@', $sanitized);
        $this->assertStringNotContainsString('#', $sanitized);
        $this->assertStringNotContainsString('<', $sanitized);
        $this->assertStringNotContainsString('>', $sanitized);
        $this->assertStringEndsWith('.jpg', $sanitized);
    }

    /**
     * Test get category by MIME type for images
     */
    public function test_get_category_by_mime_type_image()
    {
        $category = FileValidator::getCategoryByMimeType('image/jpeg');
        $this->assertEquals('image', $category);
    }

    /**
     * Test get category by MIME type for documents
     */
    public function test_get_category_by_mime_type_document()
    {
        $category = FileValidator::getCategoryByMimeType('application/pdf');
        $this->assertEquals('document', $category);
    }

    /**
     * Test get category by MIME type for archives
     */
    public function test_get_category_by_mime_type_archive()
    {
        $category = FileValidator::getCategoryByMimeType('application/zip');
        $this->assertEquals('archive', $category);
    }

    /**
     * Test get category by MIME type returns null for unknown types
     */
    public function test_get_category_by_mime_type_unknown()
    {
        $category = FileValidator::getCategoryByMimeType('application/unknown-type');
        $this->assertNull($category);
    }

    /**
     * Test file validator class exists and is callable
     */
    public function test_file_validator_class_exists()
    {
        $this->assertTrue(class_exists('App\Helpers\FileValidator'));
        $this->assertTrue(method_exists('App\Helpers\FileValidator', 'validate'));
        $this->assertTrue(method_exists('App\Helpers\FileValidator', 'sanitizeFilename'));
        $this->assertTrue(method_exists('App\Helpers\FileValidator', 'getCategoryByMimeType'));
    }
}
