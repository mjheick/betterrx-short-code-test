# betterrx-short-code-test

Some code test.

# What's requested

Thank you for your time, I enjoyed our conversation. Before scheduling a one-hour interview with our CTO [Peter](https://www.linkedin.com/in/petergalbraith) and our Lead Developer [Chris](https://www.linkedin.com/in/chris-kitchen-899599152), we’d like you to do a short code test. Please see below:

Create an application that searches the npi registry and lists the results.

User Interface Requirements
- A user should be able to search by first name, last name, npi number, taxonomy description, city, state and zip.
- 50 results or less should be displayed by default.
   - If more than 50 results are available, a mechanism to load more results or paging should be implemented.
- The application will not be required to display more than 1200 results from any given search.
- If a user clicks on a record, more information about the provider should be displayed.
   - Additional information can be formatted manually or the following url can be leveraged https://npiregistry.cms.hhs.gov/provider-view/{npi}
   - A user should be able to return to the search results easily after viewing a provider’s details.  Therefore, a modal or a back button, split-view, or other solution should be implemented.

Technical Requirements
- Bonus for Laravel backend, but can use whatever language you are comfortable with.
- Use Livewire or a Javascript framework for the frontend (Angular, React, VueJs)
- API requests to the NPI registry should be sent from the backend

API Docs: https://npiregistry.cms.hhs.gov/api-page

Deliverables: Create a private GitHub repo and invite betterrx-developers. The email is developers@betterrx.com the username is [betterrx-developers](https://github.com/betterrx-developers). Reply with an email once complete. Please also include a video demonstrating functionality if Laravel is not used.

