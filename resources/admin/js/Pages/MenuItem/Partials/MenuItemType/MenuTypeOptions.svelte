<script>
    import axios from "axios";
    import { AccordionItem, Accordion } from "flowbite-svelte";
    import { createEventDispatcher } from "svelte";

    const dispatch = createEventDispatcher();

    import { onMount } from "svelte";

    let templates = [];

    const searchVariants = () => {
        axios.get(route("sites.variants")).then((response) => {
            templates = response.data;
            console.log(templates);
        });
    };

    onMount(() => {
        searchVariants();
    });
</script>

<Accordion>
    {#each templates as template}
        <AccordionItem>
            <span slot="header">{template.label}</span>
            <ul>
                {#each template.variants as variant}
                    <li class="block">
                        <button
                            type="button"
                            class="hover:underline text-blue-600 cursor-pointer"
                            on:click={() => dispatch("selected", variant)}
                        >
                            {variant.name}
                        </button>
                    </li>
                {/each}
            </ul>
        </AccordionItem>
    {/each}
</Accordion>
