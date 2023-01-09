<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { onMounted, ref, computed } from "vue";
import BreezeNavLink from '@/Components/NavLink.vue';


// variables
const Productos = ref(null);
const Factura = ref({
    productos: [],
});
const productoSelected = ref(null);

// metodos
const getProductos = async () => {
    try {
        let { data } = await axios('/api/get-producto');
        Productos.value  = data
    } catch (error) {
        
    }
}

const deleteProductos = async (prod) => {
    try {
         await axios.delete(`/api/delete-producto/${prod.id}`);
         getProductos()
    } catch (error) {
        console.log(error)
    }
}

onMounted(() => {
    getProductos()
});

</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Productos
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        
                        <div class="flex flex-col justify-center h-full">
                            <!-- Table -->
                            <div class="w-full  mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                                <header class="px-5 py-4 border-b border-gray-100">
                                    Productos
                                </header>

                                <div class="overflow-x-auto p-3">
                                    <table class="table-auto w-full">
                                        <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                            <tr>
                                                <th class="p-2">
                                                    <div class="font-semibold text-end">Descripción del producto</div>
                                                </th>
                                                <th class="p-2">
                                                    <div class="font-semibold text-start">Total</div>
                                                </th>
                                                <th class="p-2">
                                                    <div class="font-semibold text-start">Ación</div>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody class="text-sm divide-y divide-gray-100">
                                            <tr v-for="(prod, p) in Productos" :key="p" >
                                                <td class="p-2">
                                                    <div class="font-medium text-gray-800 text-end">
                                                        {{ prod.producto }}
                                                    </div>
                                                </td>
                                                <td class="p-2">
                                                    <div class="font-medium text-green-500 text-start">
                                                        $ {{prod.precio}}
                                                    </div>
                                                </td>
                                                <td class="p-2">
                                                    <div class="flex justify-start">
                                                        <button @click="deleteProductos(prod)" >
                                                            <svg class="w-8 h-8 hover:text-blue-600 rounded-full hover:bg-gray-100 p-1"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                        <BreezeNavLink :href="route('view.productos', {producto: prod.id})" >
                                                            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <g id="style=stroke">
                                                                <g id="eye-open">
                                                                <path id="vector (Stroke)" fill-rule="evenodd" clip-rule="evenodd" d="M12 9.75C10.755 9.75 9.75 10.755 9.75 12C9.75 13.245 10.755 14.25 12 14.25C13.245 14.25 14.25 13.245 14.25 12C14.25 10.755 13.245 9.75 12 9.75ZM8.25 12C8.25 9.92657 9.92657 8.25 12 8.25C14.0734 8.25 15.75 9.92657 15.75 12C15.75 14.0734 14.0734 15.75 12 15.75C9.92657 15.75 8.25 14.0734 8.25 12Z" fill="black"/>
                                                                <path id="vector (Stroke)_2" fill-rule="evenodd" clip-rule="evenodd" d="M2.28282 9.27342C4.69299 5.94267 8.19618 3.96997 12.0001 3.96997C15.8042 3.96997 19.3075 5.94286 21.7177 9.27392C22.2793 10.0479 22.5351 11.0421 22.5351 11.995C22.5351 12.948 22.2792 13.9424 21.7174 14.7165C19.3072 18.0473 15.804 20.02 12.0001 20.02C8.19599 20.02 4.69264 18.0471 2.28246 14.716C1.7209 13.942 1.46509 12.9478 1.46509 11.995C1.46509 11.0419 1.721 10.0475 2.28282 9.27342ZM12.0001 5.46997C8.74418 5.46997 5.66753 7.15436 3.49771 10.1532L3.497 10.1542C3.15906 10.6197 2.96509 11.2866 2.96509 11.995C2.96509 12.7033 3.15906 13.3703 3.497 13.8357L3.49771 13.8367C5.66753 16.8356 8.74418 18.52 12.0001 18.52C15.256 18.52 18.3326 16.8356 20.5025 13.8367L20.5032 13.8357C20.8411 13.3703 21.0351 12.7033 21.0351 11.995C21.0351 11.2866 20.8411 10.6197 20.5032 10.1542L20.5025 10.1532C18.3326 7.15436 15.256 5.46997 12.0001 5.46997Z" fill="black"/>
                                                                </g>
                                                                </g>
                                                            </svg>
                                                        </BreezeNavLink>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
