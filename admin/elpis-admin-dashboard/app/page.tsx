import { Sidebar } from "@/components/sidebar"
import { Header } from "@/components/header"
import { MetricCard } from "@/components/metric-card"
import { ActivityFeed } from "@/components/activity-feed"
import { DonationsChart } from "@/components/charts/donations-chart"
import { ApplicationsChart } from "@/components/charts/applications-chart"
import { DonationsDistributionChart } from "@/components/charts/donations-distribution-chart"
import { FileText, Clock, DollarSign, Users } from "lucide-react"
import { Button } from "@/components/ui/button"
import Link from "next/link"
import { applications, donations, subscriptions } from "@/lib/sample-data"

export default function DashboardPage() {
  // Calculate metrics
  const totalApplications = applications.length
  const pendingApplications = applications.filter((app) => app.status === "pending").length
  const totalDonations = donations.reduce((sum, donation) => sum + donation.amount, 0)
  const activeSubscriptions = subscriptions.filter((sub) => sub.status === "Active").length

  return (
    <div className="flex h-screen">
      <Sidebar />
      <div className="flex-1 lg:ml-60">
        <Header title="Dashboard" breadcrumbs={[{ label: "Home" }]} />
        <main className="p-6">
          <div className="mx-auto max-w-7xl space-y-6">
            {/* Metrics Grid */}
            <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
              <MetricCard
                title="Total Applications"
                value={totalApplications}
                icon={FileText}
                trend={{ value: 12, isPositive: true }}
              />
              <MetricCard title="Pending Applications" value={pendingApplications} icon={Clock} highlight="warning" />
              <MetricCard
                title="Total Donations"
                value={`UGX ${(totalDonations / 1000000).toFixed(1)}M`}
                icon={DollarSign}
                trend={{ value: 8, isPositive: true }}
              />
              <MetricCard
                title="Active Subscriptions"
                value={activeSubscriptions}
                icon={Users}
                trend={{ value: 5, isPositive: true }}
              />
            </div>

            {/* Charts Section */}
            <div className="grid gap-6 lg:grid-cols-2">
              <DonationsChart />
              <ApplicationsChart />
            </div>

            <div className="grid gap-6 lg:grid-cols-3">
              <div className="lg:col-span-1">
                <DonationsDistributionChart />
              </div>
              <div className="lg:col-span-2">
                <ActivityFeed />
              </div>
            </div>

            {/* Quick Actions */}
            <div className="flex flex-wrap gap-4">
              <Link href="/management?tab=applications">
                <Button className="bg-accent-pink hover:bg-accent-pink/90">Review Applications</Button>
              </Link>
              <Link href="/management?tab=donations">
                <Button variant="outline">View Donations</Button>
              </Link>
            </div>
          </div>
        </main>
      </div>
    </div>
  )
}
