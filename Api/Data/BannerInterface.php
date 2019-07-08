<?php
namespace Weverson83\Banner\Api\Data;

/**
 * @api
 */
interface BannerInterface
{
    /**#@+
     * Constants defined for keys of the data array
     */
    const ID = 'id';
    const CONTENT = 'content';
    const ENABLED = 'enabled';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    /**#@-*/

    /**
     * Get banner id
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set banner id
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get banner html content
     *
     * @return string|null
     */
    public function getContent();

    /**
     * Set banner html content
     *
     * @param string $content
     * @return $this
     */
    public function setContent($content);

    /**
     * Check if banner is enabled
     *
     * @return bool
     */
    public function isEnabled();

    /**
     * Set enabled or disabled
     *
     * @param bool $enabled
     * @return $this
     */
    public function setEnabled($enabled);

    /**
     * Get created at time
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created at time
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * Get updated at time
     *
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set updated at time
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt);
}
