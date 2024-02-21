<script>
    import axios from "axios";
    import { onMount } from "svelte";
    import { createEventDispatcher } from "svelte";

    const dispatch = createEventDispatcher();
    let images = [];
    let file;
    let progress = 0;
    function handleFiles(event) {
        const formData = new FormData();

        for (let i = 0; i < event.target.files.length; i++) {
            formData.append("files[]", event.target.files[i]);
        }
        axios
            .post("/admin/file-manager", formData, {
                onUploadProgress: (event) => {
                    progress = Math.round((100 * event.loaded) / event.total);
                },
            })
            .then((response) => {
                images = response.data;
            })
            .catch((error) => {
                console.log(error);
            });
    }

    const openFile = () => {
        file.click();
    };

    const getFiles = () => {
        axios.get("/admin/file-manager").then((response) => {
            images = response.data;
        });
    };

    onMount(() => {
        getFiles();
    });
</script>

<div class="mb-4">
    <button
        class="p-2 bg-blue-500 text-white"
        border="1px solid blue-300"
        type="button"
        on:click={openFile}
    >
        Subir imágenes
    </button>
    {#if progress > 0}
        <span text="xs" font="bold" class="block"
            >Subiendo archivos al servidor: {progress}%
        </span>
    {/if}
</div>

<div class="grid grid-cols-4 gap-3 max-h-86 overflow-y-auto">
    {#each images as image}
        <div
            class="flex flex-col p-2 w-40 shadow-md relative"
            border="1px solid gray-300 rounded-md"
        >
            <!-- svelte-ignore a11y-img-redundant-alt -->
            <img
                src="/storage/{image.path}"
                alt="Uploaded image"
                class="object-cover w-full h-full"
            />
            <span text="xs" font="bold">{image.name}</span>
            <span text="xs gray-500" font="bold">{image.size / 1000} KB</span>

            <input
                type="radio"
                class="absolute top-0 right-0"
                value={image.path}
                on:change={() => dispatch("change", image.path)}
            />
        </div>
    {:else}
        <span text="gray-700 sm">No hay imágenes a mostrar</span>
    {/each}
</div>

<form name="form" id="form">
    <input
        type="file"
        id="files"
        name="files"
        hidden="hidden"
        accept="image/png, image/jpeg"
        multiple
        bind:this={file}
        on:input={handleFiles}
    />
</form>
