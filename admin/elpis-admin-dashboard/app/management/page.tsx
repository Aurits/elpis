"use client"

import { Sidebar } from "@/components/sidebar"
import { Header } from "@/components/header"
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs"
import { ApplicationsTable } from "@/components/applications-table"
import { DonationsTable } from "@/components/donations-table"
import { SubscriptionsTable } from "@/components/subscriptions-table"
import { useSearchParams } from "next/navigation"

export default function ManagementPage() {
  const searchParams = useSearchParams()
  const defaultTab = searchParams.get("tab") || "applications"

  return (
    <div className="flex h-screen">
      <Sidebar />
      <div className="flex-1 lg:ml-60">
        <Header title="Management" breadcrumbs={[{ label: "Home" }, { label: "Management" }]} />
        <main className="p-6">
          <div className="mx-auto max-w-7xl">
            <Tabs defaultValue={defaultTab} className="space-y-6">
              <TabsList className="grid w-full max-w-md grid-cols-3">
                <TabsTrigger value="applications">Applications</TabsTrigger>
                <TabsTrigger value="donations">Donations</TabsTrigger>
                <TabsTrigger value="subscriptions">Subscriptions</TabsTrigger>
              </TabsList>

              <TabsContent value="applications" className="space-y-4">
                <ApplicationsTable />
              </TabsContent>

              <TabsContent value="donations" className="space-y-4">
                <DonationsTable />
              </TabsContent>

              <TabsContent value="subscriptions" className="space-y-4">
                <SubscriptionsTable />
              </TabsContent>
            </Tabs>
          </div>
        </main>
      </div>
    </div>
  )
}
