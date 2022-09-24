<?php

declare(strict_types=1);

namespace Portal\Post\Tag;

class Tag implements TagInterface
{
    private string $id;
    private string $name;
    private string $slug;
    private string $icon;
    private string $previewPostId;
    private bool $approved;

    public function __construct(
        string $id,
        string $name,
        string $slug,
        string $icon,
        string $previewPostId,
        bool $approved
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
        $this->icon = $icon;
        $this->previewPostId = $previewPostId;
        $this->approved = $approved;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @return string
     */
    public function getPreviewPostId(): string
    {
        return $this->previewPostId;
    }

    /**
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->approved;
    }
}
