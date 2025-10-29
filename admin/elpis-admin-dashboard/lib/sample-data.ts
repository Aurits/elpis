export interface Application {
  id: string
  applicantName: string
  email: string
  position: string
  department: string
  region: string
  dateSubmitted: Date
  status: "pending" | "approved" | "rejected"
  cv: string
  coverLetter: string
  qualifications: string
}

export interface Donation {
  id: string
  donorName: string
  email: string
  amount: number
  paymentMethod: "Mobile Money" | "Bank" | "Card"
  transactionId: string
  date: Date
  status: "Success" | "Pending" | "Failed"
}

export interface Subscription {
  id: string
  subscriberName: string
  email: string
  phone: string
  region: string
  subscriptionDate: Date
  status: "Active" | "Inactive"
  lastEmailSent: Date
}

const departments = ["Education", "Healthcare", "Community Development", "Finance", "Operations", "Marketing"]
const regions = ["Kampala", "Wakiso", "Mukono", "Jinja", "Mbarara", "Gulu", "Lira", "Mbale"]
const positions = [
  "Program Officer",
  "Field Coordinator",
  "Project Manager",
  "Finance Officer",
  "Communications Specialist",
  "Community Mobilizer",
]
const statuses: Array<"pending" | "approved" | "rejected"> = ["pending", "approved", "rejected"]

function randomDate(start: Date, end: Date): Date {
  return new Date(start.getTime() + Math.random() * (end.getTime() - start.getTime()))
}

// Generate 50 applications
export const applications: Application[] = Array.from({ length: 50 }, (_, i) => ({
  id: `APP-${String(i + 1).padStart(4, "0")}`,
  applicantName: [
    "Sarah Nakato",
    "John Okello",
    "Mary Nambi",
    "David Mugisha",
    "Grace Atim",
    "Peter Ssemakula",
    "Jane Akello",
    "Moses Kato",
    "Ruth Nalubega",
    "Samuel Opio",
    "Rebecca Namusoke",
    "Joseph Tumusiime",
    "Esther Auma",
    "Daniel Wasswa",
    "Faith Namukasa",
    "Isaac Byaruhanga",
    "Lydia Achan",
    "Emmanuel Kiiza",
    "Agnes Nabirye",
    "Patrick Odongo",
    "Catherine Namuli",
    "Francis Okoth",
    "Juliet Nakimuli",
    "Andrew Mwesigwa",
    "Stella Aber",
    "Richard Ssali",
    "Doreen Akot",
    "Henry Lubega",
    "Brenda Nakabugo",
    "Vincent Oloya",
    "Christine Nambozo",
    "George Wanyama",
    "Harriet Namatovu",
    "Simon Okumu",
    "Josephine Nabirye",
    "Michael Kiggundu",
    "Florence Adong",
    "Paul Mukasa",
    "Betty Namuddu",
    "Charles Ochen",
    "Irene Nakawuki",
    "Robert Opolot",
    "Winnie Nakalembe",
    "Fred Okello",
    "Mercy Akello",
    "James Ssekandi",
    "Patience Apio",
    "Martin Kisakye",
    "Diana Namuyanja",
    "Kenneth Otim",
  ][i],
  email: `applicant${i + 1}@email.com`,
  position: positions[Math.floor(Math.random() * positions.length)],
  department: departments[Math.floor(Math.random() * departments.length)],
  region: regions[Math.floor(Math.random() * regions.length)],
  dateSubmitted: randomDate(new Date(2024, 6, 1), new Date()),
  status: statuses[Math.floor(Math.random() * statuses.length)],
  cv: `/documents/cv-${i + 1}.pdf`,
  coverLetter: "I am writing to express my strong interest in this position...",
  qualifications: "Bachelor's Degree in relevant field, 3+ years experience...",
}))

// Generate 100 donations
export const donations: Donation[] = Array.from({ length: 100 }, (_, i) => ({
  id: `DON-${String(i + 1).padStart(5, "0")}`,
  donorName: `Donor ${i + 1}`,
  email: `donor${i + 1}@email.com`,
  amount: Math.floor(Math.random() * 490000) + 10000,
  paymentMethod: ["Mobile Money", "Bank", "Card"][Math.floor(Math.random() * 3)] as "Mobile Money" | "Bank" | "Card",
  transactionId: `TXN${Math.random().toString(36).substring(2, 15).toUpperCase()}`,
  date: randomDate(new Date(2024, 6, 1), new Date()),
  status: ["Success", "Pending", "Failed"][Math.floor(Math.random() * 10) > 1 ? 0 : Math.floor(Math.random() * 3)] as
    | "Success"
    | "Pending"
    | "Failed",
}))

// Generate 200 subscriptions
export const subscriptions: Subscription[] = Array.from({ length: 200 }, (_, i) => ({
  id: `SUB-${String(i + 1).padStart(5, "0")}`,
  subscriberName: `Subscriber ${i + 1}`,
  email: `subscriber${i + 1}@email.com`,
  phone: `+256${Math.floor(Math.random() * 900000000) + 700000000}`,
  region: regions[Math.floor(Math.random() * regions.length)],
  subscriptionDate: randomDate(new Date(2023, 0, 1), new Date()),
  status: Math.random() > 0.2 ? "Active" : "Inactive",
  lastEmailSent: randomDate(new Date(2024, 9, 1), new Date()),
}))
