<style>
    .hr-container {
        width: 50%;
        margin: 0 auto;
        text-align: center;
    }

    .hr-text {
        font-size: 20px;
        position: relative;
        border: 0;
        height: 1.5em;
    }

    .hr-text:before {
        content: '';
        background: linear-gradient(to right, transparent, var(--color-post-border), transparent);
        position: absolute;
        left: 0;
        top: 50%;
        width: 100%;
        height: 1px;
    }

    .hr-text:after {
        content: attr(data-content);
        position: relative;
        display: inline-block;
        color: black;
        padding: 0 .5em;
        line-height: 1.5em;
        color: var(--color-bg-body);
        background-color: black;
    }
</style>

<div class="hr-container">
    <hr class="hr-text" data-content="<?= $hrText ?>">
</div>