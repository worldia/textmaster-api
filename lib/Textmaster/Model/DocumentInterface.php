<?php

namespace Textmaster\Model;

interface DocumentInterface extends TimestampedInterface
{
    /**
     * Get id.
     *
     * @return string
     */
    public function getId();

    /**
     * Get project.
     *
     * TODO: Check mutability.
     *
     * @return ProjectInterface
     */
    public function getProject();

    /**
     * Get author.
     *
     * TODO: Check mutability.
     *
     * @return AuthorInterface|null
     */
    public function getAuthor();

    /**
     * Get type.
     *
     * TODO: Check mutability.
     *
     * @return string
     */
    public function getType();

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return DocumentInterface
     */
    public function setTitle($title);

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription();

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return DocumentInterface
     */
    public function setDescription($description);

    /**
     * Get instructions.
     *
     * @return string
     */
    public function getInstructions();

    /**
     * Set instructions.
     *
     * @param string $instructions
     *
     * @return DocumentInterface
     */
    public function setInstructions($instructions);

    /**
     * Get original content.
     *
     * TODO: Check mutability.
     *
     * @return string
     */
    public function getOriginalContent();
}
