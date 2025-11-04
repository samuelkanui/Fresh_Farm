<script setup lang="ts">
import { BellRing, Check } from 'lucide-vue-next'
import { cn } from '@/lib/utils'
import { Button } from '@/components/ui/button'
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import { Switch } from '@/components/ui/switch'

type Notification = {
  title: string
  description: string
  type?: 'order' | 'booking' | 'system'
}

const props = withDefaults(defineProps<{
  notifications?: Notification[]
}>(), {
  notifications: () => []
})
</script>

<template>
  <Card :class="cn('w-[380px]', $attrs.class ?? '')">
    <CardHeader>
      <CardTitle>Notifications</CardTitle>
      <CardDescription>You have {{ notifications.length }} unread {{ notifications.length === 1 ? 'message' : 'messages' }}.</CardDescription>
    </CardHeader>
    <CardContent class="grid gap-4">
      <div class="flex items-center space-x-4 rounded-md border p-4">
        <BellRing />
        <div class="flex-1 space-y-1">
          <p class="text-sm font-medium leading-none">
            Push Notifications
          </p>
          <p class="text-sm text-muted-foreground">
            Send notifications to device.
          </p>
        </div>
        <Switch />
      </div>
      <div v-if="notifications.length > 0">
        <div
          v-for="(notification, index) in notifications"
          :key="index"
          class="mb-4 grid grid-cols-[25px_minmax(0,1fr)] items-start pb-4 last:mb-0 last:pb-0"
        >
          <span class="flex h-2 w-2 translate-y-1 rounded-full bg-sky-500" />
          <div class="space-y-1">
            <p class="text-sm font-medium leading-none">
              {{ notification.title }}
            </p>
            <p class="text-sm text-muted-foreground">
              {{ notification.description }}
            </p>
          </div>
        </div>
      </div>
      <div v-else class="text-center py-4">
        <p class="text-sm text-muted-foreground">No new notifications</p>
      </div>
    </CardContent>
    <CardFooter>
      <Button class="w-full">
        <Check class="mr-2 h-4 w-4" /> Mark all as read
      </Button>
    </CardFooter>
  </Card>
</template>
