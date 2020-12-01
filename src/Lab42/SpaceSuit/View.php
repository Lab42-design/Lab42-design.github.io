<?php

/**
 *
 * render simple two-step views
 * based on aura/view
 *
 */

declare(strict_types = 1);

namespace Lab42\SpaceSuit;

use Lab42\SpaceSuit\ViewException;
use Lab42\Domain\Payload;

use function ob_start;
use function ob_get_clean;
use function sprintf;

class View
{
    /**
     * partial view
     */
    private $view;

    /**
     * main layout
     */
    private ?string $layout = null;

    /**
     * payload for views
     */
    private $payload;

    public function __construct()
    {
    }

    public function __invoke()
    {
        // if there is no $layout, render only the $view

        $this->setContent($this->render($this->getView()));

        // TODO: check for ajax request here? or in the ADR Response?

        // TOFO
        $layout = $this->getLayout();

        // if ($layout === '' || $layout === null) {
        if (! $layout) {
            return $this->getContent();
        }

        return $this->render($layout);
    }

    /**
     *
     * getters, setters
     *
     */
    public function setLayout(string $layout = null): void
    {
        $this->layout = $layout;
    }

    public function getLayout(): string
    {
        return $this->layout;
    }

    public function setView(string $view): void
    {
        $this->view = $view;
    }
    
    public function getView(): string
    {
        return $this->view;
    }

    public function setPayload(Payload $payload): void
    {
        $this->payload = (object) $payload;
    }

    protected function setContent($content): void
    {
        $this->content = $content;
    }

    protected function getContent(): string
    {
        return $this->content;
    }

    /**
     *
     * render and io
     *
     */
    protected function render($name): string
    {
        if (!file_exists($name)) {
            throw new ViewException(sprintf('View file not found. (%s)', $name));
        }

        // extract( (array) $this->payload);

        ob_start();
        if ($this->isReadable($name)) {
            $this->enclose($name);
        }
        return ob_get_clean();
    }

    /**
     *
     * utils
     *
     */
    protected function isReadable($__FILE__): bool
    {
        return is_readable($__FILE__);
    }

    protected function enclose($__FILE__): void
    {
        require $__FILE__;
    }

    protected function esc($content, $secure = true): string
    {
        if ($secure === true) {
            $content = (string) $content;
            return htmlspecialchars($content, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8', true);
            // return htmlentities($content);
        } else {
            return $content;
        }
    }
}
