import type { LucideIcon } from "lucide-react"
import { Card, CardContent } from "@/components/ui/card"
import { TrendingUp, TrendingDown } from "lucide-react"

interface MetricCardProps {
  title: string
  value: string | number
  icon: LucideIcon
  trend?: {
    value: number
    isPositive: boolean
  }
  highlight?: "warning" | "success" | "error"
}

export function MetricCard({ title, value, icon: Icon, trend, highlight }: MetricCardProps) {
  const highlightColors = {
    warning: "border-warning/50 bg-warning/5",
    success: "border-success/50 bg-success/5",
    error: "border-error/50 bg-error/5",
  }

  return (
    <Card className={`glass-card ${highlight ? highlightColors[highlight] : ""}`}>
      <CardContent className="p-6">
        <div className="flex items-center justify-between">
          <div className="flex-1">
            <p className="text-sm font-medium text-muted-foreground">{title}</p>
            <p className="mt-2 text-3xl font-bold">{value}</p>
            {trend && (
              <div className="mt-2 flex items-center gap-1 text-sm">
                {trend.isPositive ? (
                  <TrendingUp className="h-4 w-4 text-success" />
                ) : (
                  <TrendingDown className="h-4 w-4 text-error" />
                )}
                <span className={trend.isPositive ? "text-success" : "text-error"}>{Math.abs(trend.value)}%</span>
                <span className="text-muted-foreground">vs last month</span>
              </div>
            )}
          </div>
          <div className="rounded-lg bg-muted p-3">
            <Icon className="h-6 w-6 text-foreground" />
          </div>
        </div>
      </CardContent>
    </Card>
  )
}
