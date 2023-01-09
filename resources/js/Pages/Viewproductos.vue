<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { onMounted, ref, defineProps } from "vue";
import { Inertia } from '@inertiajs/inertia';

// variables
const Productos = ref(null);
const PropProducto = defineProps({
    producto: Object
})

// metodos
const getProductos = async () => {
    try {
        let { data } = await axios('/api/get-producto');
        Productos.value  = data
    } catch (error) {
        
    }
}
const updateProductos = async () => {
    try {
         await axios.put(`/api/update-producto/${PropProducto.producto.id}`, PropProducto.producto );
          Inertia.get(route('productos'))
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
                        <div class="mt-10 sm:mt-0">
                            <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Producto</h3>
                                <p class="mt-1 text-sm text-gray-600">{{ PropProducto.producto.producto }}</p>
                                </div>
                            </div>
                            <div class="mt-5 md:col-span-2 md:mt-0">
                                <div class="overflow-hidden shadow sm:rounded-md">
                                    <div class="bg-white px-4 py-5 sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6 sm:col-span-3">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">Descripción</label>
                                        <input v-model="PropProducto.producto.producto" type="text" name="first-name" id="first-name"  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>

                                        <div class="col-span-6 sm:col-span-3">
                                        <label for="last-name" class="block text-sm font-medium text-gray-700">Precio</label>
                                        <input v-model="PropProducto.producto.precio" type="text" name="last-name" id="last-name" autocomplete="family-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>

                                        <div class="col-span-6 sm:col-span-6">
                                        <label for="email-address" class="block text-sm font-medium text-gray-700">Impuesto</label>
                                        <input v-model="PropProducto.producto.impuesto" type="text" name="email-address" id="email-address" autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                    </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                                    <button  class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" @click="updateProductos">
                                        Guardar
                                    </button>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
