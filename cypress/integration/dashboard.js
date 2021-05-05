// main.js created with Cypress
//
// Start writing your Cypress tests below!
// If you're unfamiliar with how Cypress works,
// check out the link below and learn how to write your first test:
// https://on.cypress.io/writing-first-test

const url_base = 'http://home-budget.loc';

describe('Test dashboard', () => {
    it('Check title page', () => {
        cy.visit(url_base)
        cy.get('h1')
            .should('have.text', 'Tableau de bord')
    })
    it('Check account card title', () => {
        cy.visit(url_base)
        cy.get('.card:nth-child(2)')
            .find('h5')
            .should('have.text', 'Comptes')
    })
    it('Check account card link', () => {
        cy.visit(url_base)
        cy.get('.card:nth-child(2)')
            .find('a')
            .should('have.attr', 'href')
            .then((href) => {
                cy.visit(url_base + href)
                cy.get('h1').contains('Liste des comptes')
            })
    })
})
