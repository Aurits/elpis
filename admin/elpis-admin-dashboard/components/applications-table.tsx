"use client"

import { useState } from "react"
import { applications, type Application } from "@/lib/sample-data"
import { Badge } from "@/components/ui/badge"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table"
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from "@/components/ui/dialog"
import { Card, CardContent } from "@/components/ui/card"
import { Search, Download, Eye, CheckCircle, XCircle, ChevronDown, ChevronUp } from "lucide-react"
import { useToast } from "@/hooks/use-toast"

export function ApplicationsTable() {
  const { toast } = useToast()
  const [searchQuery, setSearchQuery] = useState("")
  const [statusFilter, setStatusFilter] = useState("all")
  const [departmentFilter, setDepartmentFilter] = useState("all")
  const [regionFilter, setRegionFilter] = useState("all")
  const [currentPage, setCurrentPage] = useState(1)
  const [selectedApplication, setSelectedApplication] = useState<Application | null>(null)
  const [expandedRows, setExpandedRows] = useState<Set<string>>(new Set())
  const [confirmDialog, setConfirmDialog] = useState<{
    open: boolean
    type: "approve" | "reject" | null
    application: Application | null
  }>({ open: false, type: null, application: null })

  const itemsPerPage = 10

  // Filter applications
  const filteredApplications = applications.filter((app) => {
    const matchesSearch =
      app.applicantName.toLowerCase().includes(searchQuery.toLowerCase()) ||
      app.email.toLowerCase().includes(searchQuery.toLowerCase()) ||
      app.position.toLowerCase().includes(searchQuery.toLowerCase())
    const matchesStatus = statusFilter === "all" || app.status === statusFilter
    const matchesDepartment = departmentFilter === "all" || app.department === departmentFilter
    const matchesRegion = regionFilter === "all" || app.region === regionFilter

    return matchesSearch && matchesStatus && matchesDepartment && matchesRegion
  })

  // Pagination
  const totalPages = Math.ceil(filteredApplications.length / itemsPerPage)
  const startIndex = (currentPage - 1) * itemsPerPage
  const paginatedApplications = filteredApplications.slice(startIndex, startIndex + itemsPerPage)

  // Get unique values for filters
  const departments = Array.from(new Set(applications.map((app) => app.department)))
  const regions = Array.from(new Set(applications.map((app) => app.region)))

  const toggleRowExpansion = (id: string) => {
    const newExpanded = new Set(expandedRows)
    if (newExpanded.has(id)) {
      newExpanded.delete(id)
    } else {
      newExpanded.add(id)
    }
    setExpandedRows(newExpanded)
  }

  const handleAction = (type: "approve" | "reject", application: Application) => {
    setConfirmDialog({ open: true, type, application })
  }

  const confirmAction = () => {
    if (confirmDialog.application && confirmDialog.type) {
      toast({
        title: `Application ${confirmDialog.type === "approve" ? "Approved" : "Rejected"}`,
        description: `${confirmDialog.application.applicantName}'s application has been ${confirmDialog.type}d.`,
      })
      setConfirmDialog({ open: false, type: null, application: null })
    }
  }

  const exportToCSV = () => {
    toast({
      title: "Export Started",
      description: "Your CSV file is being prepared for download.",
    })
  }

  const getStatusBadge = (status: Application["status"]) => {
    const variants = {
      pending: "bg-warning/20 text-warning border-warning/50",
      approved: "bg-success/20 text-success border-success/50",
      rejected: "bg-error/20 text-error border-error/50",
    }
    return (
      <Badge variant="outline" className={variants[status]}>
        {status.charAt(0).toUpperCase() + status.slice(1)}
      </Badge>
    )
  }

  return (
    <div className="space-y-4">
      {/* Filters */}
      <Card className="glass-card">
        <CardContent className="p-4">
          <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-5">
            <div className="relative lg:col-span-2">
              <Search className="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
              <Input
                placeholder="Search by name, email, or position..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="pl-9"
              />
            </div>
            <Select value={statusFilter} onValueChange={setStatusFilter}>
              <SelectTrigger>
                <SelectValue placeholder="Status" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="all">All Status</SelectItem>
                <SelectItem value="pending">Pending</SelectItem>
                <SelectItem value="approved">Approved</SelectItem>
                <SelectItem value="rejected">Rejected</SelectItem>
              </SelectContent>
            </Select>
            <Select value={departmentFilter} onValueChange={setDepartmentFilter}>
              <SelectTrigger>
                <SelectValue placeholder="Department" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="all">All Departments</SelectItem>
                {departments.map((dept) => (
                  <SelectItem key={dept} value={dept}>
                    {dept}
                  </SelectItem>
                ))}
              </SelectContent>
            </Select>
            <Select value={regionFilter} onValueChange={setRegionFilter}>
              <SelectTrigger>
                <SelectValue placeholder="Region" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="all">All Regions</SelectItem>
                {regions.map((region) => (
                  <SelectItem key={region} value={region}>
                    {region}
                  </SelectItem>
                ))}
              </SelectContent>
            </Select>
          </div>
          <div className="mt-4 flex items-center justify-between">
            <p className="text-sm text-muted-foreground">
              Showing {startIndex + 1}-{Math.min(startIndex + itemsPerPage, filteredApplications.length)} of{" "}
              {filteredApplications.length} applications
            </p>
            <Button variant="outline" size="sm" onClick={exportToCSV}>
              <Download className="mr-2 h-4 w-4" />
              Export CSV
            </Button>
          </div>
        </CardContent>
      </Card>

      {/* Table */}
      <Card className="glass-card">
        <CardContent className="p-0">
          <div className="overflow-x-auto">
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead className="w-12"></TableHead>
                  <TableHead>Applicant Name</TableHead>
                  <TableHead>Email</TableHead>
                  <TableHead>Position</TableHead>
                  <TableHead>Department</TableHead>
                  <TableHead>Region</TableHead>
                  <TableHead>Date Submitted</TableHead>
                  <TableHead>Status</TableHead>
                  <TableHead className="text-right">Actions</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                {paginatedApplications.map((app) => (
                  <>
                    <TableRow key={app.id} className="hover:bg-muted/50">
                      <TableCell>
                        <Button
                          variant="ghost"
                          size="sm"
                          onClick={() => toggleRowExpansion(app.id)}
                          className="h-8 w-8 p-0"
                        >
                          {expandedRows.has(app.id) ? (
                            <ChevronUp className="h-4 w-4" />
                          ) : (
                            <ChevronDown className="h-4 w-4" />
                          )}
                        </Button>
                      </TableCell>
                      <TableCell className="font-medium">{app.applicantName}</TableCell>
                      <TableCell className="text-muted-foreground">{app.email}</TableCell>
                      <TableCell>{app.position}</TableCell>
                      <TableCell>{app.department}</TableCell>
                      <TableCell>{app.region}</TableCell>
                      <TableCell>{app.dateSubmitted.toLocaleDateString()}</TableCell>
                      <TableCell>{getStatusBadge(app.status)}</TableCell>
                      <TableCell className="text-right">
                        <div className="flex justify-end gap-2">
                          <Button variant="ghost" size="sm" onClick={() => setSelectedApplication(app)}>
                            <Eye className="h-4 w-4" />
                          </Button>
                          {app.status === "pending" && (
                            <>
                              <Button
                                variant="ghost"
                                size="sm"
                                onClick={() => handleAction("approve", app)}
                                className="text-success hover:text-success"
                              >
                                <CheckCircle className="h-4 w-4" />
                              </Button>
                              <Button
                                variant="ghost"
                                size="sm"
                                onClick={() => handleAction("reject", app)}
                                className="text-error hover:text-error"
                              >
                                <XCircle className="h-4 w-4" />
                              </Button>
                            </>
                          )}
                        </div>
                      </TableCell>
                    </TableRow>
                    {expandedRows.has(app.id) && (
                      <TableRow>
                        <TableCell colSpan={9} className="bg-muted/30">
                          <div className="space-y-4 p-4">
                            <div>
                              <h4 className="font-semibold mb-2">Cover Letter</h4>
                              <p className="text-sm text-muted-foreground">{app.coverLetter}</p>
                            </div>
                            <div>
                              <h4 className="font-semibold mb-2">Qualifications</h4>
                              <p className="text-sm text-muted-foreground">{app.qualifications}</p>
                            </div>
                            <div>
                              <Button variant="outline" size="sm">
                                <Download className="mr-2 h-4 w-4" />
                                Download CV
                              </Button>
                            </div>
                          </div>
                        </TableCell>
                      </TableRow>
                    )}
                  </>
                ))}
              </TableBody>
            </Table>
          </div>
        </CardContent>
      </Card>

      {/* Pagination */}
      <div className="flex items-center justify-between">
        <Button variant="outline" disabled={currentPage === 1} onClick={() => setCurrentPage(currentPage - 1)}>
          Previous
        </Button>
        <span className="text-sm text-muted-foreground">
          Page {currentPage} of {totalPages}
        </span>
        <Button variant="outline" disabled={currentPage === totalPages} onClick={() => setCurrentPage(currentPage + 1)}>
          Next
        </Button>
      </div>

      {/* View Details Dialog */}
      <Dialog open={!!selectedApplication} onOpenChange={() => setSelectedApplication(null)}>
        <DialogContent className="max-w-2xl">
          <DialogHeader>
            <DialogTitle>Application Details</DialogTitle>
            <DialogDescription>Full details for {selectedApplication?.applicantName}</DialogDescription>
          </DialogHeader>
          {selectedApplication && (
            <div className="space-y-4">
              <div className="grid grid-cols-2 gap-4">
                <div>
                  <p className="text-sm font-medium text-muted-foreground">Name</p>
                  <p className="text-sm">{selectedApplication.applicantName}</p>
                </div>
                <div>
                  <p className="text-sm font-medium text-muted-foreground">Email</p>
                  <p className="text-sm">{selectedApplication.email}</p>
                </div>
                <div>
                  <p className="text-sm font-medium text-muted-foreground">Position</p>
                  <p className="text-sm">{selectedApplication.position}</p>
                </div>
                <div>
                  <p className="text-sm font-medium text-muted-foreground">Department</p>
                  <p className="text-sm">{selectedApplication.department}</p>
                </div>
                <div>
                  <p className="text-sm font-medium text-muted-foreground">Region</p>
                  <p className="text-sm">{selectedApplication.region}</p>
                </div>
                <div>
                  <p className="text-sm font-medium text-muted-foreground">Status</p>
                  {getStatusBadge(selectedApplication.status)}
                </div>
              </div>
              <div>
                <p className="text-sm font-medium text-muted-foreground mb-2">Cover Letter</p>
                <p className="text-sm leading-relaxed">{selectedApplication.coverLetter}</p>
              </div>
              <div>
                <p className="text-sm font-medium text-muted-foreground mb-2">Qualifications</p>
                <p className="text-sm leading-relaxed">{selectedApplication.qualifications}</p>
              </div>
            </div>
          )}
          <DialogFooter>
            <Button variant="outline" onClick={() => setSelectedApplication(null)}>
              Close
            </Button>
            <Button>
              <Download className="mr-2 h-4 w-4" />
              Download CV
            </Button>
          </DialogFooter>
        </DialogContent>
      </Dialog>

      {/* Confirmation Dialog */}
      <Dialog
        open={confirmDialog.open}
        onOpenChange={(open) => !open && setConfirmDialog({ open: false, type: null, application: null })}
      >
        <DialogContent>
          <DialogHeader>
            <DialogTitle>{confirmDialog.type === "approve" ? "Approve Application" : "Reject Application"}</DialogTitle>
            <DialogDescription>
              Are you sure you want to {confirmDialog.type} the application from{" "}
              {confirmDialog.application?.applicantName}?
            </DialogDescription>
          </DialogHeader>
          <DialogFooter>
            <Button variant="outline" onClick={() => setConfirmDialog({ open: false, type: null, application: null })}>
              Cancel
            </Button>
            <Button
              onClick={confirmAction}
              className={
                confirmDialog.type === "approve" ? "bg-success hover:bg-success/90" : "bg-error hover:bg-error/90"
              }
            >
              {confirmDialog.type === "approve" ? "Approve" : "Reject"}
            </Button>
          </DialogFooter>
        </DialogContent>
      </Dialog>
    </div>
  )
}
