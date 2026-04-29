<?php
function ledger_path() {
    return __DIR__ . "/data/ledger.json";
}

function ensure_ledger_exists() {
    $path = ledger_path();
    $dir = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    if (!file_exists($path)) {
        $genesis = [
            "index" => 0,
            "timestamp" => date("Y-m-d H:i:s"),
            "type" => "genesis",
            "record_id" => "0",
            "payload" => ["message" => "Genesis block"],
            "prev_hash" => "0",
        ];
        $genesis["hash"] = hash("sha256", json_encode($genesis));
        file_put_contents($path, json_encode([$genesis], JSON_PRETTY_PRINT));
    }
}

function read_ledger() {
    ensure_ledger_exists();
    $data = json_decode(file_get_contents(ledger_path()), true);
    return is_array($data) ? $data : [];
}

function write_ledger($ledger) {
    file_put_contents(ledger_path(), json_encode($ledger, JSON_PRETTY_PRINT));
}

function append_block($type, $recordId, $payload) {
    $ledger = read_ledger();
    $last = end($ledger);
    $index = is_array($last) ? ((int) $last["index"] + 1) : 1;
    $prevHash = is_array($last) ? $last["hash"] : "0";

    $block = [
        "index" => $index,
        "timestamp" => date("Y-m-d H:i:s"),
        "type" => $type,
        "record_id" => $recordId,
        "payload" => $payload,
        "prev_hash" => $prevHash
    ];
    $block["hash"] = hash("sha256", json_encode($block));

    $ledger[] = $block;
    write_ledger($ledger);

    return $block;
}
