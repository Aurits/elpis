import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import { FileText, DollarSign, Mail, CheckCircle, XCircle, Clock } from "lucide-react"

interface Activity {
  id: string
  type: "application" | "donation" | "subscription"
  message: string
  timestamp: Date
  status?: "success" | "pending" | "error"
}

const activities: Activity[] = [
  {
    id: "1",
    type: "application",
    message: "New application from Sarah Nakato for Program Officer",
    timestamp: new Date(Date.now() - 1000 * 60 * 5),
    status: "pending",
  },
  {
    id: "2",
    type: "donation",
    message: "Donation of UGX 250,000 received from John Doe",
    timestamp: new Date(Date.now() - 1000 * 60 * 15),
    status: "success",
  },
  {
    id: "3",
    type: "application",
    message: "Application approved for David Mugisha",
    timestamp: new Date(Date.now() - 1000 * 60 * 30),
    status: "success",
  },
  {
    id: "4",
    type: "subscription",
    message: "New newsletter subscription from Grace Atim",
    timestamp: new Date(Date.now() - 1000 * 60 * 45),
    status: "success",
  },
  {
    id: "5",
    type: "donation",
    message: "Donation of UGX 100,000 from Mary Nambi",
    timestamp: new Date(Date.now() - 1000 * 60 * 60),
    status: "success",
  },
  {
    id: "6",
    type: "application",
    message: "Application rejected for Peter Ssemakula",
    timestamp: new Date(Date.now() - 1000 * 60 * 90),
    status: "error",
  },
  {
    id: "7",
    type: "donation",
    message: "Donation of UGX 500,000 received from Anonymous",
    timestamp: new Date(Date.now() - 1000 * 60 * 120),
    status: "success",
  },
  {
    id: "8",
    type: "subscription",
    message: "Newsletter sent to 150 subscribers",
    timestamp: new Date(Date.now() - 1000 * 60 * 180),
    status: "success",
  },
  {
    id: "9",
    type: "application",
    message: "New application from Jane Akello for Field Coordinator",
    timestamp: new Date(Date.now() - 1000 * 60 * 240),
    status: "pending",
  },
  {
    id: "10",
    type: "donation",
    message: "Donation of UGX 75,000 from Moses Kato",
    timestamp: new Date(Date.now() - 1000 * 60 * 300),
    status: "success",
  },
]

function getActivityIcon(type: Activity["type"]) {
  switch (type) {
    case "application":
      return FileText
    case "donation":
      return DollarSign
    case "subscription":
      return Mail
  }
}

function getStatusIcon(status?: Activity["status"]) {
  switch (status) {
    case "success":
      return CheckCircle
    case "error":
      return XCircle
    case "pending":
      return Clock
    default:
      return null
  }
}

function getStatusColor(status?: Activity["status"]) {
  switch (status) {
    case "success":
      return "text-success"
    case "error":
      return "text-error"
    case "pending":
      return "text-warning"
    default:
      return "text-muted-foreground"
  }
}

function formatTimestamp(date: Date): string {
  const now = new Date()
  const diff = now.getTime() - date.getTime()
  const minutes = Math.floor(diff / 60000)
  const hours = Math.floor(minutes / 60)
  const days = Math.floor(hours / 24)

  if (minutes < 60) return `${minutes}m ago`
  if (hours < 24) return `${hours}h ago`
  return `${days}d ago`
}

export function ActivityFeed() {
  return (
    <Card className="glass-card">
      <CardHeader>
        <CardTitle>Recent Activity</CardTitle>
      </CardHeader>
      <CardContent>
        <div className="space-y-4">
          {activities.map((activity) => {
            const Icon = getActivityIcon(activity.type)
            const StatusIcon = getStatusIcon(activity.status)
            const statusColor = getStatusColor(activity.status)

            return (
              <div key={activity.id} className="flex items-start gap-4">
                <div className="rounded-lg bg-muted p-2">
                  <Icon className="h-4 w-4" />
                </div>
                <div className="flex-1 space-y-1">
                  <p className="text-sm leading-relaxed">{activity.message}</p>
                  <p className="text-xs text-muted-foreground">{formatTimestamp(activity.timestamp)}</p>
                </div>
                {StatusIcon && <StatusIcon className={`h-4 w-4 ${statusColor}`} />}
              </div>
            )
          })}
        </div>
      </CardContent>
    </Card>
  )
}
