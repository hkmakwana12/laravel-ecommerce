<div x-data="editor(`{!! $slot !!}`)" class="card">
    <template x-if="isLoaded()">
        <div class="card-header border-b border-base-content/20">
            <div class="flex items-center gap-1 flex-wrap">
                <!-- Paragraph -->
                <button type="button" @click="setParagraph()" class="btn btn-soft btn-sm btn-square"
                    :class="{
                        'btn-primary hover:btn-primary': isActive('paragraph', updatedAt),
                        'btn-secondary hover:btn-secondary': !isActive('paragraph', updatedAt)
                    }">
                    <span class="icon-[tabler--pilcrow] size-4.5"></span>
                </button>

                <!-- Headings -->
                <button type="button" @click="toggleHeading({ level: 2 })" class="btn btn-soft btn-sm btn-square"
                    :class="{
                        'btn-primary hover:btn-primary': isActive('heading', { level: 2 }, updatedAt),
                        'btn-secondary hover:btn-secondary': !isActive('heading', { level: 2 }, updatedAt)
                    }">
                    <span class="icon-[tabler--h-2] size-4.5"></span>
                </button>
                <button type="button" @click="toggleHeading({ level: 3 })" class="btn btn-soft btn-sm btn-square"
                    :class="{
                        'btn-primary hover:btn-primary': isActive('heading', { level: 3 }, updatedAt),
                        'btn-secondary hover:btn-secondary': !isActive('heading', { level: 3 }, updatedAt)
                    }">
                    <span class="icon-[tabler--h-3] size-4.5"></span>
                </button>
                <button type="button" @click="toggleHeading({ level: 4 })" class="btn btn-soft btn-sm btn-square"
                    :class="{
                        'btn-primary hover:btn-primary': isActive('heading', { level: 4 }, updatedAt),
                        'btn-secondary hover:btn-secondary': !isActive('heading', { level: 4 }, updatedAt)
                    }">
                    <span class="icon-[tabler--h-4] size-4.5"></span>
                </button>

                <!-- Divider -->
                <div class="h-6 w-px bg-gray-300 mx-1"></div>

                <!-- Text Styles -->
                <button type="button" @click="toggleBold()" class="btn btn-soft btn-sm btn-square"
                    :class="{
                        'btn-primary hover:btn-primary': isActive('bold', updatedAt),
                        'btn-secondary hover:btn-secondary': !isActive('bold', updatedAt)
                    }">
                    <span class="icon-[tabler--bold] size-4.5"></span>
                </button>
                <button type="button" @click="toggleItalic()" class="btn btn-soft btn-sm btn-square"
                    :class="{
                        'btn-primary hover:btn-primary': isActive('italic', updatedAt),
                        'btn-secondary hover:btn-secondary': !isActive('italic', updatedAt)
                    }">
                    <span class="icon-[tabler--italic] size-4.5"></span>
                </button>
                <button type="button" @click="toggleUnderline()" class="btn btn-soft btn-sm btn-square"
                    :class="{
                        'btn-primary hover:btn-primary': isActive('underline', updatedAt),
                        'btn-secondary hover:btn-secondary': !isActive('underline', updatedAt)
                    }">
                    <span class="icon-[tabler--underline] size-4.5"></span>
                </button>
                <button type="button" @click="toggleCode()" class="btn btn-soft btn-sm btn-square"
                    :class="{
                        'btn-primary hover:btn-primary': isActive('code', updatedAt),
                        'btn-secondary hover:btn-secondary': !isActive('code', updatedAt)
                    }">
                    <span class="icon-[tabler--code] size-4.5"></span>
                </button>

                <!-- Divider -->
                <div class="h-6 w-px bg-gray-300 mx-1"></div>

                <!-- Lists -->
                <button type="button" @click="toggleBulletList()" class="btn btn-soft btn-sm btn-square"
                    :class="{
                        'btn-primary hover:btn-primary': isActive('bulletList', updatedAt),
                        'btn-secondary hover:btn-secondary': !isActive('bulletList', updatedAt)
                    }">
                    <span class="icon-[tabler--list] size-4.5"></span>
                </button>
                <button type="button" @click="toggleOrderedList()" class="btn btn-soft btn-sm btn-square"
                    :class="{
                        'btn-primary hover:btn-primary': isActive('orderedList', updatedAt),
                        'btn-secondary hover:btn-secondary': !isActive('orderedList', updatedAt)
                    }">
                    <span class="icon-[tabler--list-numbers] size-4.5"></span>
                </button>

                <!-- Optional: Add more icons as needed -->
                <button type="button" @click="toggleBlockquote()" class="btn btn-soft btn-sm btn-square"
                    :class="{
                        'btn-primary hover:btn-primary': isActive('blockquote', updatedAt),
                        'btn-secondary hover:btn-secondary': !isActive('blockquote', updatedAt)
                    }">
                    <span class="icon-[tabler--quote] size-4.5"></span>
                </button>
                {{-- <button type="button" @click="toggleLink()"
                    :class="{ 'btn btn-secondary': isActive('link', updatedAt) }"
                    class="btn btn-soft btn-sm btn-square">
                    <span class="icon-[tabler--link] size-4.5"></span>
                </button> --}}
            </div>
        </div>
    </template>

    <!-- Editor Content Area -->
    <div x-ref="element" class="card-body mt-6 prose max-w-none focus:outline-none focus:ring-0"></div>

    <!-- Hidden Input for Form Submission -->
    <input x-ref="hiddenInput" type="hidden" name="{{ $name }}" value="{!! $slot !!}" />
</div>
