<?php
/**
 *      Inline Styles for the Admin Notice
 *
 **/

?>
<!-- * I output inline styles here 
	 * because there's no reason to keep these
	 * enqueued after the alert is dismissed. -->

<style>
    div.give-addon-alert.updated {
        padding: 1em 2em;
        position: relative;
        border-color: #66BB6A;
    }

    div.give-addon-alert img {
        max-width: 50px;
        position: relative;
        top: 1em;
    }

    div.give-addon-alert h3 {
        display: inline;
        position: relative;
        top: -20px;
        left: 20px;
        font-size: 24px;
        font-weight: 300;
    }

    div.give-addon-alert h3 span {
        font-weight: 900;
        color: #66BB6A;
    }

    div.give-addon-alert .alert-actions {
        position: relative;
        left: 70px;
        top: -10px;

    }

    div.give-addon-alert a {
        color: #66BB6A;
        margin-right: 2em;
    }

    div.give-addon-alert .alert-actions a {
        text-decoration: underline;
    }

    div.give-addon-alert .alert-actions a:hover {
        color: #555555;
    }

    div.give-addon-alert .alert-actions a span {
        text-decoration: none;
        margin-right: 5px;
    }

    div.give-addon-alert .dismiss {
        position: absolute;
        right: 0;
        height: 100%;
        top: 50%;
        margin-top: -10px;
        outline: none;
        box-shadow: none;
        text-decoration: none;
    }
</style>