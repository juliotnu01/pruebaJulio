<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { onMounted, ref, computed } from "vue";
import BreezeNavLink from '@/Components/NavLink.vue';


// variables
const Compras = ref(null);
const factura = ref([]);

const subTotalFactura = computed({
    get: () => { 
        let subtotal = 0;
        const { value } = factura
        for (let index = 0; index < value.length; index++) {
            const element = value[index];
            subtotal += parseInt(element.subtotal)
        } 
        return subtotal
     },
    set: (val) => { factura.value = val }
})

const IvasubTotalFactura = computed({
    get: () => { 
        let ivasubtotal = 0;
        const { value } = factura
        for (let index = 0; index < value.length; index++) {
            const element = value[index];
            ivasubtotal += parseInt(element.iva)
        } 
        return ivasubtotal
     },
    set: (val) => { factura.value = val }
})
const TotalFactura = computed({
    get: () => { 
        let total = 0;
        const { value } = factura
        for (let index = 0; index < value.length; index++) {
            const element = value[index];
            total += parseInt(element.total)
        } 
        return total
     },
    set: (val) => { factura.value = val }
})


// metodos
const getCompras = async () => {
    try {
        let { data } = await axios('/api/get-compras');
        Compras.value  = data
    } catch (error) {
        
    }
}

const generateFactura = async (e, comp) => {
    try {
        if(e.target.checked){
            await factura.value.push(comp)
        }else{
            let index = factura.value.findIndex(x => x.id === comp.id);
            if (index !== -1) {
                factura.value.splice(index, 1);
            }
        }
    } catch (error) {
        console.log(error)
    }
}



onMounted(() => {
    getCompras()
});

</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Facturas
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
                                    <div class="font-semibold text-gray-800">
                                        Compras
                                    </div>
                                </header>

                                <div class="overflow-x-auto p-3">
                                    <table class="table-auto w-full">
                                        <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                            <tr>
                                                <th class="p-2">
                                                    <div class="font-semibold text-center">Compra ID</div>
                                                </th>
                                                <th class="p-2">
                                                    <div class="font-semibold text-end">SubTtal</div>
                                                </th>
                                                <th class="p-2">
                                                    <div class="font-semibold text-center">Impuesto</div>
                                                </th>
                                                <th class="p-2">
                                                    <div class="font-semibold text-start">Total</div>
                                                </th>
                                                <th class="p-2">
                                                    <div class="font-semibold text-start">Productos</div>
                                                </th>
                                                <th class="p-2">
                                                    <div class="font-semibold text-center">Fecha</div>
                                                </th>
                                                <th class="p-2">
                                                    <div class="font-semibold text-center">Ación</div>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody class="text-sm divide-y divide-gray-100">
                                            <tr v-for="(compra, c) in Compras" :key="c"  >
                                                <td class="p-2">
                                                    <div class="font-medium text-gray-800 text-center">
                                                        {{ compra.id }}
                                                    </div>
                                                </td>
                                                <td class="p-2">
                                                    <div class="font-medium  text-end">
                                                        $ {{compra.subtotal}}
                                                    </div>
                                                </td>
                                                <td class="p-2">
                                                    <div class="font-medium  text-center">
                                                        $ {{compra.iva}}
                                                    </div>
                                                </td>
                                                <td class="p-2">
                                                    <div class="font-medium  text-start">
                                                        $ {{compra.total}}
                                                    </div>
                                                </td>
                                                <td class="p-2">
                                                    <div class="font-medium  text-start" v-for="(ProdCompra, pc) in compra.has_many_productos_compra" :key="pc">
                                                        <span class=" mb-3 px-4 py-2 rounded-full text-gray-500 bg-gray-200 font-semibold text-sm flex align-center w-max cursor-pointer active:bg-gray-300 transition duration-300 ease">
                                                            {{ProdCompra.belong_to_producto.producto}}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="p-2">
                                                    <div class="font-medium  text-center" >
                                                        {{ compra.created_at.substr(0,10) }}
                                                    </div>
                                                </td>
                                                <td class="p-2">
                                                    <div class="flex justify-center">
                                                        <input @click="generateFactura($event, compra)" class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" value="" id="flexCheckDefault">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- total amount -->
                                <div class="flex justify-end font-bold space-x-4 text-2xl border-t border-gray-100 px-5 py-4">
                                    <div>Sub-Total</div>
                                    <div class="text-blue-600">
                                        $<span>{{ subTotalFactura  }}</span>
                                    </div>
                                </div>
                                <div class="flex justify-end font-bold space-x-4 text-2xl border-t border-gray-100 px-5 py-4">
                                    <div>I.V.A</div>
                                    <div class="text-blue-600">
                                        $<span> {{ IvasubTotalFactura  }}  </span>
                                    </div>
                                </div>
                                <div class="flex justify-end font-bold space-x-4 text-2xl border-t border-gray-100 px-5 py-4">
                                    <div>TOTAL</div>
                                    <div class="text-blue-600">
                                        $<span> {{  TotalFactura  }}  </span>
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <!-- send this data to backend (note: use class 'hidden' to hide this input) -->
                                    <input type="hidden" class="border border-black bg-gray-50" x-model="selected" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </BreezeAuthenticatedLayout>
</template>
