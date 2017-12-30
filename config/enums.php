<?php
    /* enumerals used by the app */
    return [
        'Chamber' => [
            1 => 'House',
            2 => 'Senate',
        ],
        'ActionTypes' => [
            0 => "Unknown",
            1 => "Committee Reading",
            2 => "Second Reading",
            3 => "Third Reading",
            4 => "Assigned To Committee",
            5 => "Sent to Governor",
            6 => "Signed by Governor",
            7 => "Vetoed by Governor",
            8 => "Veto overridden"
        ],
        'DigestType' => [
            0 => "None",
            1 => "MyBills",
            2 => "AllBills",
        ],
        'MessageType' => [
            1 => "Email",
            2 => "SMS"
        ],
        'CommitteePosition' => [
            1  => "Member",
            2  => "Ranking Minority",
            3  => "Vice Chair",
            4  => "Chair",
            5  => "Advisor",
            6  => "Conferee"
        ],
        'BillPosition' => [
            1 => "Author",
            2 => "CoAuthor",
            3 => "Sponsor",
            4 => "CoSponsor"
        ]
    ];
