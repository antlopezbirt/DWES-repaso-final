<?php

class ApiJsonResponse implements JsonSerializable {
    private String $status;
    private int $bodyCode;
    private String $description;
    private $data;

    public function __construct($status, $code, $description, $data) {
        $this->status = $status;
        $this->bodyCode = $code;
        $this->description = $description;
        $this->data = $data;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'status' => $this->status,
            'code' => $this->bodyCode,
            'description' => $this->description,
            'data' => $this->data
        ];
    }
}