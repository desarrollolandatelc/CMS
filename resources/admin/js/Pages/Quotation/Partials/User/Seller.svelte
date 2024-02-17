<script>
    import axios from "axios";
    import { Label, Select } from "flowbite-svelte";
    import { onMount } from "svelte";

    export let form;

    let users = [];

    const searchSellers = () => {
        axios
            .get(route("users.search"))
            .then((response) => {
                users = response.data;
            })
            .catch((error) => {
                console.log(error);
            });
    };

    onMount(() => {
        searchSellers();
    });
</script>

<Label for="client" class="block w-full">
    Vendedor <sup class="text-red-600">*</sup>
</Label>
{#if $form.status === "pending"}
    <Select bind:value={$form.user_id} id="user_id" name="user_id">
        {#each users as user}
            <option value={user.id}>{user.name}</option>
        {/each}
    </Select>
{:else}
    <span>{$form.user?.name}</span>
{/if}
