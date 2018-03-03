<?php
declare(strict_types = 1);

namespace Nepada\MetaControl;

use Nette;
use Nette\Utils\Html;


class MetaControl extends Nette\Application\UI\Component
{

    private const META_AUTHOR = 'author';
    private const META_DESCRIPTION = 'description';
    private const META_KEYWORDS = 'keywords';
    private const META_ROBOTS = 'robots';

    /** @var string|null */
    private $charset;

    /** @var string[] */
    private $metadata = [];

    /** @var string[] */
    private $properties = [];

    /** @var string[] */
    private $pragmas = [];


    public function render(): void
    {
        if ($this->charset !== null) {
            echo Html::el('meta', ['charset' => $this->charset]) . "\n";
        }
        foreach ($this->metadata as $name => $content) {
            echo Html::el('meta', ['name' => $name, 'content' => $content]) . "\n";
        }
        foreach ($this->properties as $name => $content) {
            echo Html::el('meta', ['property' => $name, 'content' => $content]) . "\n";
        }
        foreach ($this->pragmas as $httpEquiv => $content) {
            echo Html::el('meta', ['http-equiv' => $httpEquiv, 'content' => $content]) . "\n";
        }
    }

    public function getCharset(): ?string
    {
        return $this->charset;
    }

    public function setCharset(?string $charset): void
    {
        $this->charset = $charset;
    }

    public function getMetadata(string $name): ?string
    {
        return Nette\Utils\Arrays::get($this->metadata, $name, null);
    }

    public function setMetadata(string $name, ?string $content): void
    {
        if ($content === null) {
            unset($this->metadata[$name]);
        } else {
            $this->metadata[$name] = $content;
        }
    }

    public function getProperty(string $name): ?string
    {
        return Nette\Utils\Arrays::get($this->properties, $name, null);
    }

    public function setProperty(string $property, ?string $content): void
    {
        if ($content === null) {
            unset($this->properties[$property]);
        } else {
            $this->properties[$property] = $content;
        }
    }

    public function getPragma(string $name): ?string
    {
        return Nette\Utils\Arrays::get($this->pragmas, $name, null);
    }

    public function setPragma(string $httpEquiv, ?string $content): void
    {
        if ($content === null) {
            unset($this->pragmas[$httpEquiv]);
        } else {
            $this->pragmas[$httpEquiv] = $content;
        }
    }

    public function getAuthor(): ?string
    {
        return $this->getMetadata(self::META_AUTHOR);
    }

    public function setAuthor(?string $author): void
    {
        $this->setMetadata(self::META_AUTHOR, $author);
    }

    public function getDescription(): ?string
    {
        return $this->getMetadata(self::META_DESCRIPTION);
    }

    public function setDescription(?string $description): void
    {
        $this->setMetadata(self::META_DESCRIPTION, $description);
    }

    /**
     * @return string[]
     */
    public function getKeywords(): array
    {
        $keywords = $this->getMetadata(self::META_KEYWORDS);
        return $keywords === null ? [] : array_map('trim', explode(',', $keywords));
    }

    /**
     * @param string[] ...$keywords
     */
    public function setKeywords(string ...$keywords): void
    {
        if ($keywords === []) {
            $this->setMetadata(self::META_KEYWORDS, null);
        } else {
            $keywords = array_map('trim', $keywords);
            $keywords = array_unique($keywords);
            $this->setMetadata(self::META_KEYWORDS, implode(', ', $keywords));
        }
    }

    public function addKeyword(string $keyword): void
    {
        $keywords = $this->getKeywords();
        $keywords[] = $keyword;
        $this->setKeywords(...$keywords);
    }

    public function getRobots(): ?string
    {
        return $this->getMetadata(self::META_ROBOTS);
    }

    public function setRobots(?string $robots): void
    {
        $this->setMetadata(self::META_ROBOTS, $robots);
    }

}
