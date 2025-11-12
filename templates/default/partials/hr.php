<style>
    .una {
        text-align: center;
        display: block;
        line-height: 1px;
        height: 1px;
        margin: 2rem 0;
        color: var(--color-post-border);
    }

    .una+span:before {
        content: "\00A7";
        color: var(--color-post-border);
        font-size: 4rem;
        position: absolute;
        top: -1rem;
        left: 50%;
        transform: translateX(-50%) rotate(90deg);
        transform-origin: center;
    }
</style>

<div class="container position-relative">
    <hr class='una' />
    <span></span>
</div>