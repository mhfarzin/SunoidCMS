<style>
    .landscape {
        border: 4px solid var(--color-post-border);
        padding: 16px;
        position: absolute;
    }

    .landscape .content {
        width: 100%;
        border: 4px solid var(--color-post-border);
        border-radius: 5px;
        padding: 16px;
        background-color: var(--color-bg-main);
    }

    .landscape:before,
    .landscape:after,
    .landscape .content:before,
    .landscape .content:after {
        content: "";
        position: absolute;
        width: 42px;
        height: 42px;
        border: 4px solid;
    }

    .landscape:before {
        top: -4px;
        left: -4px;
        border-color: var(--color-bg-body) var(--color-post-border) var(--color-post-border) var(--color-bg-body);
        border-radius: 0 0 5px 0;
    }

    .landscape:after {
        top: -4px;
        right: -4px;
        border-color: var(--color-bg-body) var(--color-bg-body) var(--color-post-border) var(--color-post-border);
        border-radius: 0 0 0 5px;
    }

    .landscape .content:before {
        bottom: -4px;
        left: -4px;
        border-color: var(--color-post-border) var(--color-post-border) var(--color-bg-body) var(--color-bg-body);
        border-radius: 0 5px 0 0;
    }

    .landscape .content:after {
        bottom: -4px;
        right: -4px;
        border-color: var(--color-post-border) var(--color-bg-body) var(--color-bg-body) var(--color-post-border);
        border-radius: 5px 0 0 0;
    }
</style>

<div class="container position-relative mt-5 mb-3" style="height: 230px;">
    <div class="landscape w-100">
        <div class="content">
            <h3>Welcome to Floating Leaves</h3>
            <div class="post-body">
                <p>This is a sample post demonstrating the Floating Leaves template. It features a clean design, nature-inspired background, and elegant typography.</p>
                <blockquote>“Design is not just what it looks like and feels like. Design is how it works.” — Steve Jobs</blockquote>
                <p>You can easily adapt this template for your blog, portfolio, or personal site. Add your content, images, and make it your own.</p>
            </div>
        </div>
    </div>
</div>