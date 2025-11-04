<script setup lang="ts">
import { computed } from 'vue'

type ChartData = {
    label: string
    value: number
    color: string
}

const props = defineProps<{
    data: ChartData[]
    title?: string
}>()

const total = computed(() => props.data.reduce((sum, item) => sum + item.value, 0))

const slices = computed(() => {
    if (total.value === 0) return []
    
    let currentAngle = -90 // Start from top
    return props.data.filter(item => item.value > 0).map(item => {
        const percentage = (item.value / total.value) * 100
        const sliceAngle = (item.value / total.value) * 360
        
        const startAngle = currentAngle
        const endAngle = currentAngle + sliceAngle
        currentAngle = endAngle
        
        // Calculate path for pie slice
        const startRad = (startAngle * Math.PI) / 180
        const endRad = (endAngle * Math.PI) / 180
        
        const x1 = 100 + 80 * Math.cos(startRad)
        const y1 = 100 + 80 * Math.sin(startRad)
        const x2 = 100 + 80 * Math.cos(endRad)
        const y2 = 100 + 80 * Math.sin(endRad)
        
        const largeArc = sliceAngle > 180 ? 1 : 0
        
        const path = `M 100 100 L ${x1} ${y1} A 80 80 0 ${largeArc} 1 ${x2} ${y2} Z`
        
        return {
            ...item,
            path,
            percentage: percentage.toFixed(1)
        }
    })
})
</script>

<template>
    <div class="space-y-4">
        <h3 v-if="title" class="text-lg font-semibold">{{ title }}</h3>
        
        <div v-if="total === 0" class="text-center py-8">
            <p class="text-muted-foreground">No data available yet</p>
        </div>
        
        <div v-else class="flex flex-col md:flex-row items-center gap-6">
            <!-- Pie Chart -->
            <div class="relative">
                <svg viewBox="0 0 200 200" class="w-48 h-48">
                    <g v-for="(slice, index) in slices" :key="index">
                        <path
                            :d="slice.path"
                            :fill="slice.color"
                            class="transition-all duration-300 hover:opacity-80 cursor-pointer"
                            :title="`${slice.label}: ${slice.percentage}%`"
                        />
                    </g>
                </svg>
            </div>

            <!-- Legend -->
            <div class="flex-1 space-y-2">
                <div v-for="(slice, index) in slices" :key="index" class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <div 
                            class="w-4 h-4 rounded"
                            :style="{ backgroundColor: slice.color }"
                        ></div>
                        <span class="text-sm font-medium">{{ slice.label }}</span>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-bold">{{ slice.value }}</span>
                        <span class="text-xs text-muted-foreground ml-1">({{ slice.percentage }}%)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
