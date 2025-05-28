<?php
namespace ArgoCD\Model;

class AccountAccountsList
{
    /** @var AccountAccount[] */
    private array $items = [];

    // Potentially a V1ListMeta $metadata property if the API includes list metadata

    public function __construct(array $data = [])
    {
        if (isset($data['items']) && is_array($data['items'])) {
            foreach ($data['items'] as $accountData) {
                if (is_array($accountData)) {
                    $this->items[] = new AccountAccount($accountData);
                }
            }
        }
        // Initialize metadata if present, e.g.:
        // if (isset($data['metadata'])) {
        //     $this->metadata = new V1ListMeta($data['metadata']);
        // }
    }

    /**
     * @return AccountAccount[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    // Getter for metadata if added
    // public function getMetadata(): ?V1ListMeta
    // {
    //     return $this->metadata;
    // }
}
